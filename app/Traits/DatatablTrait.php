<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait DatatablTrait
{

    public function checkBox($id)
    {
        return '<div class="checkbox-zoom zoom-primary m-0">
            <label class="m-0">
                <input type="checkbox" value="' . $id . '" class="custome-checkbox is_check" name="ids[]" id="variants_id_' . $id . '" >
                <span class="cr m-0">
                    <i class="cr-icon ik ik-check txt-primary"></i>
                </span>
            </label>
        </div>';
    }

    public function image($exist, $width = '20%')
    {
        //dd($exist);

        if (is_null($exist) || !Storage::exists($exist)) {
            $img_url =  asset('assets/images/default/default-image.png');
        }

        if (!is_null($exist) && Storage::exists($exist)) {
            $img_url =  asset('storage/' . $exist);
        }

        return '
            <div>
                <img src="' . $img_url . '" style="width:' . $width . '" alt="">
            </div>
        ';
    }

    public function action($data)
    {
        return view('components.action')->with('list_item', $data)->render();
    }

    public function link($action, $icon = null)
    {
        return '<p class="text-center">
            <a href="' . $action . '" class=" text-center btn-sm btn btn-primary btn-elevate-hover btn-circle btn-icon"><i class="fab fa fa-key text-white"></i></a>
        </p>';
    }

    public function message($action, $icon = null)
    {
        return '<p class="">
            <a href="' . $action . '"><h3><i class="flaticon-multimedia"></i></h3></a>
        </p>';
    }

    public function a($action, $text)
    {
        return '<div class="">
            <a href="' . $action . '" class="btn-elevate-hover btn-circle btn-icon">' . $text . '</a>
        </div>';
    }

    public function status($isYes, $id, $url, $table)
    {
        //dd($table);
        if (($isYes == 'yes' || $isYes == 'YES' || $isYes == 'Yes') && $isYes !== NULL) {
            $isYes = '<div class="text-center">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input change-status" id="status_' . $id . '" name="status_' . $id . '" data-url="' . $url . '" data-table="' . $table . '" value="' . $id . '"  checked>
                      <label class="custom-control-label" for="status_' . $id . '"></label>
                    </div>
                  </div>';
        } else {
            $isYes = '
                    <div class="text-center">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input change-status" id="status_' . $id . '" name="status_' . $id . '" data-url="' . $url . '" value="' . $id . '" data-table="' . $table . '">
                      <label class="custom-control-label" for="status_' . $id . '"></label>
                    </div>
                  </div>';
        }
        return $isYes;
    }


    public function text($item, $class = NULL)
    {
        return  '<p class="' . $class . '">' . $item . '</p>';
    }

    public function badge($item)
    {
        return '<span class="badge badge-success">' . $item . '</span>';
    }

    public function roles($item)
    {
        $data = "";

        $data .= '<div class="demo-inline-spacing">';
        foreach ($item as $i) {
            $data .= '<div style="margin-top:-6px;" class="badge badge-primary">' . $i->name . '</div>';
        }
        $data .= '</div>';

        return $data;
    }
}
