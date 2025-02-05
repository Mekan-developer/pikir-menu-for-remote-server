<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = ['name', 'image', 'parent_id'];
    public $translatable = ['name'];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function foods()
    {
        return $this->hasMany(Food::class);
    }

    public function activeFoods()
    {
        return $this->foods()->whereIsActive(true)->get();
    }

    public function getImage()
    {
        if(file_exists(public_path('uploads/categories/' . $this->image)) && !is_null($this->image)){
            return asset('uploads/categories/' . $this->image);
        }else{
            return null;
        }        
    }
    
    public function getTabletImage()
    {
        if(file_exists(public_path('tablet/categories/' . $this->image)) && !is_null($this->image)){
            return asset('tablet/categories/' . $this->image);
        }else{
            return null;
        }        
    }

    public function hasParent()
    {
        return $this->parent()->exists();
    }

    public function hasChildren()
    {
        return $this->children()->exists();
    }

    public function foodsCount()
    {
        if ($this->hasChildren()) {
            $sum = 0;

            foreach ($this->children as $child) {
                $sum += $child->foods()->count();
            }

            return $sum;
        }

        return $this->foods()->count();
    }
}
