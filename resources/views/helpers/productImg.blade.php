@php
    // Specify the image directory and the default image file name
    $imageDirectory = 'images/autos/';
    $defaultImgFile = 'default.jpg';

    // Check if $imgFile is empty; if so, use the default image file name
    if (empty($imgFile)) {
        $imgFile = $defaultImgFile;
    } else {
        // If $imgFile is not empty, check if the image file exists
        if (!file_exists(public_path($imageDirectory . $imgFile))) {
            // If the image file doesn't exist, use the default image file name
            $imgFile = $defaultImgFile;
        }
    }

    // Build the URL for the image using the asset function
    $imageUrl = asset($imageDirectory . $imgFile);

    if (null !== $attrs) {
        $attrs = 'class="' . $attrs . '"';
    }
@endphp

<img src="{{ $imageUrl }}" {!! $attrs !!}>
