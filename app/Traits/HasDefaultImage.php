<?php


namespace App\Traits;


trait HasDefaultImage
// {
//     public function getImage($altText) {
//         if(!$this->image){
//             return "https://ui-avatars.com/api/?name=$altText&size=180";
//             }
//        return $this->Image;
//     }
// }
{
    public function getImage($altText) {
        if(!$this->image){
            return "https://ui-avatars.com/api/?name=$altText&size=180";
            }
       return $this->image;
    }
}