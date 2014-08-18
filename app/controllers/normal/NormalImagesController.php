<?php

class NormalImagesController extends BaseController {

	
	/**
     * Image Model
     * @var Image
     */
    protected $image;

    /**
     * Inject the models.
     * @param Image $image
     */
    public function __construct(ImageModel $image)
    {
        parent::__construct();
        $this->image = $image;
    }

	/**
	 * Image setting page.
	 *
	 * @return View
	 */
	public function getIndex()
	{
        // Show the page
        return View::make('normal/image/index');
	}

	/**
     * Uploading multiple images method.
     *
     * @return View
     */
    public function postUpload()
    {
        $files = Input::file('file');
        $serializedFile = array();

        foreach ($files as $file) {
            // Validate files from input file
            $validation = ImageModel::validateImage(array('file'=> $file));

            if (! $validation->fails()) {

                // If validation pass, get filename and extension
                // Generate random (12 characters) string
                // And specify a folder name of uploaded image
                $fileName        = $file->getClientOriginalName();
                $extension       = $file->getClientOriginalExtension();
                $folderName      = str_random(12);
                $destinationPath = 'uploads/' . $folderName;

                // Move file to generated folder
                $file->move($destinationPath, $fileName);

                // Crop image (possible by Intervention Image Class)
                // And save as miniature
                Image::make($destinationPath . '/' . $fileName)
                		->resize(null, 120, function ($constraint) {$constraint->aspectRatio();})
                		->save($destinationPath . '/min_' . $fileName);

                // Insert image information to database
                //Images::insertImage($folderName, $fileName);
            } else {
                return Redirect::to('normal/images')
                        ->with('status', 'alert-danger')
                        ->with('image-message', 'There is a problem uploading your image!');
            }

            $serializedFile[] = $folderName;
        }

        return Redirect::to('normal/images')
                ->with('status', 'alert-success')
                ->with('files', $serializedFile)
                ->with('image-message', 'Congratulations! Your photo(s) has been added');
    }

}