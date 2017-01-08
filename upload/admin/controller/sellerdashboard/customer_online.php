<?php

class ControllersellerdashboardcustomerOnline extends Controller
{
    public function index()
    {
        $this->load->language('sellerdashboard/customer_online');

        $this->document->setTitle($this->language->get('heading_title'));

        if (isset($this->request->get['filter_ip'])) {
            $filter_ip = $this->request->get['filter_ip'];
        } else {
            $filter_ip = null;
        }

        if (isset($this->request->get['filter_seller'])) {
            $filter_seller = $this->request->get['filter_seller'];
        } else {
            $filter_seller = null;
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['filter_seller'])) {
            $url .= '&filter_seller='.urlencode($this->request->get['filter_seller']);
        }

        if (isset($this->request->get['filter_ip'])) {
            $url .= '&filter_ip='.$this->request->get['filter_ip'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page='.$this->request->get['page'];
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'href' => $this->url->link('common/dashboard', 'token='.$this->session->data['token'], 'SSL'),
            'text' => $this->language->get('text_home'),
        );

        $data['breadcrumbs'][] = array(
            'href' => $this->url->link('sellerdashboard/seller_online', 'token='.$this->session->data['token'].$url, 'SSL'),
            'text' => $this->language->get('heading_title'),
        );

        $this->load->model('sellerdashboard/customer');
        $this->load->model('seller/seller');

        $data['sellers'] = array();

        $filter_data = array(
            'filter_ip' => $filter_ip,
            'filter_seller' => $filter_seller,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin'),
        );

        $seller_total = $this->model_sellerdashboard_customer->getTotalcustomersOnline($filter_data);

        $results = $this->model_sellerdashboard_customer->getcustomersOnline($filter_data);

        foreach ($results as $result) {
            $seller_info = $this->model_seller_seller->getseller($result['customer_id']);

            if ($seller_info) {
                $seller = $seller_info['firstname'].' '.$seller_info['lastname'];
            } else {
                $seller = $this->language->get('text_guest');
            }

            $data['sellers'][] = array(
                'customer_id' => $result['customer_id'],
                'ip' => $result['ip'],
                'seller' => $seller,
                'url' => $result['url'],
                'referer' => $result['referer'],
                'date_added' => date($this->language->get('datetime_format'), strtotime($result['date_added'])),
                'edit' => $this->url->link('seller/seller/edit', 'token='.$this->session->data['token'].'&seller_id='.$result['customer_id'], 'SSL'),
            );
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_list'] = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_confirm'] = $this->language->get('text_confirm');

        $data['column_ip'] = $this->language->get('column_ip');
        $data['column_seller'] = $this->language->get('column_seller');
        $data['column_url'] = $this->language->get('column_url');
        $data['column_referer'] = $this->language->get('column_referer');
        $data['column_date_added'] = $this->language->get('column_date_added');
        $data['column_action'] = $this->language->get('column_action');

        $data['entry_ip'] = $this->language->get('entry_ip');
        $data['entry_seller'] = $this->language->get('entry_seller');

        $data['button_edit'] = $this->language->get('button_edit');
        $data['button_filter'] = $this->language->get('button_filter');

        $data['token'] = $this->session->data['token'];

        $url = '';

        if (isset($this->request->get['filter_seller'])) {
            $url .= '&filter_seller='.urlencode($this->request->get['filter_seller']);
        }

        if (isset($this->request->get['filter_ip'])) {
            $url .= '&filter_ip='.$this->request->get['filter_ip'];
        }

        $pagination = new Pagination();
        $pagination->total = $seller_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('sellerdashboard/seller_online', 'token='.$this->session->data['token'].$url.'&page={page}', 'SSL');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($seller_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($seller_total - $this->config->get('config_limit_admin'))) ? $seller_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $seller_total, ceil($seller_total / $this->config->get('config_limit_admin')));

        $data['filter_seller'] = $filter_seller;
        $data['filter_ip'] = $filter_ip;

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('sellerdashboard/customer_online.tpl', $data));
    }
}
