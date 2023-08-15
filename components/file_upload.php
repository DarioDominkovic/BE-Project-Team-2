<?php

    function fileUpload($picture, $source = "user") {
        if($picture["error"] == 4) {
            $pictureName = "avatar.png";

        if($source == "crud_activity"){
            $pictureName = "morning.png";
        }

            $message = "No picture has been chosen, you can upload a picture later";
        }
        else {
            $checkIfImage = getimagesize($picture["tmp_name"]);
            $message = $checkIfImage ? "ok" : "not a picture";
        }

        if ($message == "ok") {
            $ext = strtolower(pathinfo($picture["name"], PATHINFO_EXTENSION));
            $pictureName = uniqid("" ). "." . $ext;
            $destination = "../pictures/{$pictureName}";

            if($source =="crud_activity"){
                $destination = "../pictures/{$pictureName}";
            }

            move_uploaded_file($picture["tmp_name" ], $destination);
        }
        elseif ($message == "not a picture"){
            $pictureName = "avatar.png";
            $message = "the file that you selected is not a picture, you can upload a picture later";
        }

        return [$pictureName, $message];
    }

    ?>