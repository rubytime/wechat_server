<?php

class ImageModel extends Eloquent {

	protected $table = 'images';

	/**
     * Uploading image validation rules.
     *
     * @var array
     */
    public static $rules = array(
        'file' => 'mimes:jpeg,bmp,png'
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
}