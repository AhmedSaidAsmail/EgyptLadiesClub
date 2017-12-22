<?php

namespace App\Src;

use App\Models\Section;

class SectionChilds {

    private $section;
    private $categories = [];

    private function __construct(Section $section) {
        $this->section = $section;
    }

    private static function getInstance(Section $section) {
        return new self($section);
    }

    private function setCategories() {

        foreach ($this->section->categories as $category) {
            if (count($this->categories) < 4) {
                $this->setCategoryItem($category);
            }
        }

        return $this;
    }

    private function setCategoryItem($category) {

        if (count($category->category_links) > 0) {
            $this->setCategoryLinks($category);
        }
        else {
            $details = [];
            $details['type'] = 'category';
            $details['id'] = $category->id;
            $details['en_name'] = $category->en_name;
            $details['ar_name'] = $category->ar_name;
            $details['img'] = $category->img;
            $this->categories[] = $details;
        }
    }

    private function setCategoryLinks($category) {
        $details = [];

        foreach ($category->category_links as $link) {
            if (count($this->categories) < 4) {
                $details['type'] = 'category_link';
                $details['id'] = $category->id;
                $details['en_name'] = $category->en_name;
                $details['ar_name'] = $category->ar_name;
                $details['header1'] = $link->header1;
                $details['header2'] = $link->header2;
                $details['img'] = $link->link_img;
                $details['link'] = $link->link;
                $this->categories[] = $details;
            }
        }
    }

    private function getCategories() {
        return $this->categories;
    }

    public static function Childs(Section $section) {
        return self::getInstance($section)
                        ->setCategories()
                        ->getCategories();
    }

}
