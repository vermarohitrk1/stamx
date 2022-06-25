<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addon extends Model {

    protected $fillable = [
        'title',
        'pins',
        'appointments',
        'directory',
        'description',
        'status',
        'demolink',
        'features',
        'subtitle',
        'addon_key',
        'icon',
        'image',
        'usage_status',
        'category',
    ];
    protected $table = 'addons';

    public function getPlanAddonsKeysByIds($ids) {
        if (count($ids)) {
            return self::whereIn('id', $ids)->get('addon_key');
        }
    }

    public function getAddonsKeys($table) {

        return $addons = self::where(['table_identifier' => $table])->first('addon_key');
    }

    public function AddonsKeycheck($key) {
        $response = array(
            'status' => false,
            'message' => '',
            'data' => []
        );
        $addon = self::where(['addon_key' => $key])->first();
        if (!empty($addon)) {
            $response = array(
                'status' => false,
                'message' => 'addon_key Already used',
                'data' => $addon
            );
        } else {
            $response = array(
                'status' => true,
                'message' => 'addon_key available for use',
                'data' => $addon
            );
        }
        return $response;
    }

}
