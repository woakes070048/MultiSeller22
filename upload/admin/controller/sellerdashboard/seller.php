<?php

class Controllersellerdashboardseller extends Controller
{
    public function index()
    {
        $this->load->language('sellerdashboard/seller');

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_view'] = $this->language->get('text_view');

        $data['token'] = $this->session->data['token'];

        // Total Orders
        $this->load->model('seller/seller');

        $today = $this->model_seller_seller->getTotalsellers(array('filter_date_added' => date('Y-m-d', strtotime('-1 day'))));

        $yesterday = $this->model_seller_seller->getTotalsellers(array('filter_date_added' => date('Y-m-d', strtotime('-2 day'))));

        $difference = $today - $yesterday;

        if ($difference && $today) {
            $data['percentage'] = round(($difference / $today) * 100);
        } else {
            $data['percentage'] = 0;
        }

        $seller_total = $this->model_seller_seller->getTotalsellers(array('filter_seller_approved' => true));

        if ($seller_total > 1000000000000) {
            $data['total'] = round($seller_total / 1000000000000, 1).'T';
        } elseif ($seller_total > 1000000000) {
            $data['total'] = round($seller_total / 1000000000, 1).'B';
        } elseif ($seller_total > 1000000) {
            $data['total'] = round($seller_total / 1000000, 1).'M';
        } elseif ($seller_total > 1000) {
            $data['total'] = round($seller_total / 1000, 1).'K';
        } else {
            $data['total'] = $seller_total;
        }

        $data['seller'] = $this->url->link('seller/seller', 'token='.$this->session->data['token']. '&filter_seller_approved=1', 'SSL');

        return $this->load->view('sellerdashboard/seller.tpl', $data);
    }
}
