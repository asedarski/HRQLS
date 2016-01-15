<?php
/**
 * Crime API endpoint controller.
 *
 * @package HRQLS/Controllers
 */

namespace HRQLS\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Elasticsearch\Client;

/**
 * Controller for Crime API endpoint.
 */
class Crime
{
    /**
     * Entrypoint for Crime endpoint.
     *
     * @param Request     $req The request object.
     * @param Application $app The silex application object.
     *
     * @return Response
     */
    public function main(Request $req, Application $app)
    {
        $sliderPercentage = $req->get('slidervalue') / 100;
        $slider = floor($sliderPercentage * 12) ;
        $params = array(
            'index'  => 'hrqls',
            'type'   => 'crimedata',
            'body' => [
                'from' => 0,
                'size' => 10000,
                'query' => [
                    'range' => [
                        'severity' => [
                            'gte' => $slider
                        ]
                    ]
                ]
            ]
        );
        $result = $app['elasticsearch']->search($params);
        $node = [];
        if ($result['hits']['total'] > 0) {
            $node = $result['hits']['hits'];
        }

        $crimedata = [];
        foreach ($node as $field => $crimes) {
            $data['title'] = $crimes['_source']['title'];
            $data['latitude'] = $crimes['_source']['location']['lat'];
            $data['longitude'] = $crimes['_source']['location']['lon'];
            $data['severity'] = $crimes['_source']['severity'];
            $crimedata[] = $data;
        }

        return new Response(json_encode($crimedata), 201);
    }
}
