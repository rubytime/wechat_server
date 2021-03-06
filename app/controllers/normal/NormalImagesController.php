<?php

class NormalImagesController extends BaseController {

	
	/**
     * Image Model
     * @var Image
     */
    protected $image;

    /**
     * User Model
     * @var User
     */
    protected $user;

    /**
     * Inject the models.
     * @param Image $image
     */
    public function __construct(ImageModel $image, User $user)
    {
        parent::__construct();
        $this->image = $image;
        $this->user = $user;
    }

	/**
	 * Image setting page.
	 *
	 * @return View
	 */
	public function getIndex()
	{
        // Show the page
        $images = $this->image->orderBy('created_at', 'DESC')->get();
        return View::make('normal/image/index', compact('images'));
	}

	/**
     * Uploading multiple images method.
     *
     * @return View
     */
    public function postUpload()
    {
        $user = $this->user->currentUser();
        $canUpload = $user->can('manage_config');
        if(!$canUpload)
        {
            return Redirect::to('normal/images')
                        ->with('status', 'alert-danger')
                        ->with('image-message', 'You need to be logged in with normal user to upload images!');
        }
        $files = Input::file('file');
        $serializedFile = array();

        foreach ($files as $file) {
            // Validate files from input file
            $validation = ImageModel::validateImage(array('file'=> $file));

            if (! $validation->fails() && !empty($file)) {

                // If validation pass, get filename and extension
                // Generate random (12 characters) string
                // And specify a folder name of uploaded image
                $fileName        = $file->getClientOriginalName();
                $extension       = $file->getClientOriginalExtension();
                $folderName      = str_random(12);
                $destinationPath = 'public/uploads/' . $folderName;

                // Move file to generated folder
                $file->move($destinationPath, $fileName);

                // Crop image (possible by Intervention Image Class)
                // And save as miniature
                Image::make($destinationPath . '/' . $fileName)
                		->resize(null, 160, function ($constraint) {$constraint->aspectRatio();})
                		->save($destinationPath . '/min_' . $fileName);

               	$imageModel = new ImageModel;
                $imageModel->user_id = Auth::user()->id;
                $imageModel->img_big = 'uploads/' . $folderName . '/' . $fileName;
                $imageModel->img_min = 'uploads/' . $folderName . '/min_' . $fileName; 
                $imageModel->save();
            } else {
                return Redirect::to('normal/images')
                        ->with('status', 'alert-danger')
                        ->with('image-message', 'There is a problem uploading your image!');
            }

            $serializedFile[] = $folderName;
        }

        return Redirect::to('normal/images')
                ->with('status', 'alert-success')
                ->with('image-message', 'Congratulations! Your photo(s) has been added');
    }

}