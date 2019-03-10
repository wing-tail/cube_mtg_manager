<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

class SetController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function input()
    {
        return view('set.input');
    }

    public function confirm(Request $request)
    {
        $card_list = preg_split(
            "(\r|\n|\r\n)",
            trim($request->input('cards')),
            null,
            PREG_SPLIT_NO_EMPTY
        );
        $card_detail_list = $this->getCardDetailList($card_list);
        $save_data = json_encode($card_detail_list);
        return view(
            'set.confirm',
            compact(
                'card_detail_list',
                'save_data'
            )
        );
    }

    private function getCardDetailList(array $card_list): array
    {
        $card_detail_list;
        $client = curl_init();
        foreach ($card_list as $card) {
            $card_names = explode('/', $card);
            $en_name = !empty($card_names[1])
                ? $card_names[1]
                : $card_names[0];
            $url = 'https://api.magicthegathering.io/v1/cards?name=';
            if (strpos($en_name, '+')) {
                $cards = explode('+', $en_name);
                $url .= urlencode($cards[0]);
            } else {
                $url .= urlencode($en_name);
            }
            curl_setopt_array(
                $client,
                [
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYPEER => false,
                ]
            );
            $response = curl_exec($client);
            $result = json_decode($response, true);
            foreach ($result['cards'] as $detail) {
                if (empty($detail['imageUrl'])
                    || strtolower($detail['name']) !== strtolower($en_name)
                ) {
                    continue;
                }
                $card_detail_list[$en_name] = $this->generateDetail($detail);
                break;
            }
        }
        curl_close($client);
        return $card_detail_list;
    }

    private function generateDetail(array $detail): array
    {
        $image_url = $detail['imageUrl'];
        if (count($detail['colors']) > 1) {
            $color_type = 6;
        } else if (count($detail['colors']) === 1) {
            $color = reset($detail['colors']);
            switch ($color) {
            case 'White':
                $color_type = 1;
                break;
            case 'Blue':
                $color_type = 2;
                break;
            case 'Black':
                $color_type = 3;
                break;
            case 'Red':
                $color_type = 4;
                break;
            case 'Green':
                $color_type = 5;
                break;
            default:
                throw new Exception();
            }
        } else {
            $color_type = 7;
        }
        $row_json_data = [
            'colors' => $detail['colors'],
            'multiverseid' => $detail['multiverseid'],
        ];
        if (!empty($detail['names'])) {
            $row_json_data['names'] = $detail['names'];
        }
        return [
            'name' => $detail['name'],
            'color_type' => $color_type,
            'image_url' => $image_url,
            'json_data' => $row_json_data,
        ];
    }
}
