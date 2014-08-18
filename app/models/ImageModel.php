<?php

class ImageModel extends Eloquent {

	protected $table = 'images';

	/**
     * Uploading image validation rules.
     *
     * @var array
     */
    public static $rules = array(
        'file' => 'mimes:jpeg,bmp,png|max:3000'
    );

    /**
     * Validate image method.
     *
     * @param  file $data
     * @return object Validator
     */
    public static function validateImage($data)
    {
        return Validator::make($data, static::$rules);
    }

    /**
     * Insert image to database table;
     *
     * @param  string $folderName
     * @param  string $fileName
     * @return array
     */
    public static function insertImage($folderName, $fileName)
    {
        return Images::insert(array(
                    'id'         => $folderName,
                    'user_id'    => Auth::check() ? Auth::user()->id : 0,
                    'img_big'    => $fileName,
                    'img_min'    => 'min_' . $fileName,
                    'ip'         => Request::getClientIp(),
                    'private'    => Input::get('private') ? 1 : 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
        ));
    }
}