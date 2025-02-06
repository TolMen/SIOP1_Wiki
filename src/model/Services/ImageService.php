<?php

// Bibliothéque GD trouver sur internet

class ImageService
{
    public static function compressAndResizeImage($source, $destination, $maxWidth, $maxHeight, $quality)
    {
        // Obtenir les informations de l'image
        $info = getimagesize($source);
        if (!$info) {
            return false; // L'image est invalide
        }

        list($width, $height) = $info;
        $mime = $info['mime'];

        // Charger l'image source
        $image = self::createImageFromSource($source, $mime);
        if (!$image) {
            return false;
        }

        // Redimensionner l'image si nécessaire
        list($newWidth, $newHeight) = self::calculateNewSize($width, $height, $maxWidth, $maxHeight);
        $imageResized = imagecreatetruecolor($newWidth, $newHeight);

        // Gérer la transparence pour les PNG
        if ($mime === 'image/png') {
            imagealphablending($imageResized, false);
            imagesavealpha($imageResized, true);
        }

        // Redimensionner l'image
        imagecopyresampled($imageResized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Enregistrer l'image compressée
        $success = self::saveCompressedImage($imageResized, $destination, $mime, $quality);

        // Libérer la mémoire
        imagedestroy($image);
        imagedestroy($imageResized);

        return $success;
    }

    private static function createImageFromSource($source, $mime)
    {
        switch ($mime) {
            case 'image/jpeg':
                return imagecreatefromjpeg($source);
            case 'image/png':
                return imagecreatefrompng($source);
            case 'image/gif':
                return imagecreatefromgif($source);
            default:
                return false;
        }
    }

    private static function saveCompressedImage($image, $destination, $mime, $quality)
    {
        switch ($mime) {
            case 'image/jpeg':
                return imagejpeg($image, $destination, $quality);
            case 'image/png':
                return imagepng($image, $destination, $quality / 10);
            case 'image/gif':
                return imagegif($image, $destination);
            default:
                return false;
        }
    }

    private static function calculateNewSize($width, $height, $maxWidth, $maxHeight)
    {
        if ($width > $maxWidth || $height > $maxHeight) {
            $ratio = min($maxWidth / $width, $maxHeight / $height);
            return [round($width * $ratio), round($height * $ratio)];
        }
        return [$width, $height];
    }
}
