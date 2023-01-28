<?php


class MCDefines
{
    static $_INSTANCE;

    private $struct_images;
    private $struct_files;

    /**
     * @param null $entity
     * @return mixed
     */
    public function getStructImages($entity = null)
    {
        if (!$this->struct_images) {
            $this->struct_images = array(
                'category' => array(
                    array(
                        'path' => _PS_CAT_IMG_DIR_,
                        'ext' => '.jpg',
                    )
                ),
                'manufacturer' => array(
                    array(
                        'path' => _PS_MANU_IMG_DIR_,
                        'ext' => '.jpg',
                    )
                ),
                'supplier' => array(
                    array(
                        'path' => _PS_SUPP_IMG_DIR_,
                        'ext' => '.jpg',
                    )
                ),
                'carrier' => array(
                    array(
                        'path' => _PS_SHIP_IMG_DIR_,
                        'ext' => '.jpg',
                    )
                ),
                'image' => array(
                    array(
                        'path' => _PS_PROD_IMG_DIR_,
                        'ext' => '.jpg',
                    )
                ),
                'ybc_blog_gallery_lang' => array(
                    array(
                        'path' => _PS_IMG_DIR_ . 'ybc_blog/gallery',
                        'field' => 'image',
                    ),
                    array(
                        'path' => _PS_IMG_DIR_ . 'ybc_blog/gallery/thumb',
                        'field' => 'thumb',
                    )
                ),
                'ybc_blog_category_lang' => array(
                    array(
                        'path' => _PS_IMG_DIR_ . 'ybc_blog/category',
                        'field' => 'image',
                    ),
                    array(
                        'path' => _PS_IMG_DIR_ . 'ybc_blog/category/thumb',
                        'field' => 'thumb',
                    )
                ),
                'ybc_blog_post_lang' => array(
                    array(
                        'path' => _PS_IMG_DIR_ . 'ybc_blog/post',
                        'field' => 'image',
                    ),
                    array(
                        'path' => _PS_IMG_DIR_ . 'ybc_blog/post/thumb',
                        'field' => 'thumb',
                    )
                ),
                'ybc_blog_slide_lang' => array(
                    array(
                        'path' => _PS_IMG_DIR_ . 'ybc_blog/slide',
                        'field' => 'image',
                    )
                ),
                'ybc_blog_employee' => array(
                    array(
                        'path' => _PS_IMG_DIR_ . 'ybc_blog/avata',
                        'field' => 'avata',
                    )
                ),
                'ets_mm_block' => array(
                    array(
                        'path' => _PS_MODULE_DIR_ . 'ets_megamenu/views/img/upload',
                        'field' => 'image',
                    )
                ),
            );
        }
        return $entity ? (isset($this->struct_images[$entity]) ? $this->struct_images[$entity] : array()) : $this->struct_images;
    }

    /**
     * @param null $entity
     * @return mixed
     */
    public function getStructFiles($entity = null)
    {
        if (!$this->struct_files) {
            $this->struct_files = array(
                'attachment' => array(
                    array(
                        'path' => _PS_DOWNLOAD_DIR_,
                        'field' => 'file',
                    )
                ),
                'product_download' => array(
                    array(
                        'path' => _PS_DOWNLOAD_DIR_,
                        'field' => 'filename',
                    )
                ),
                'customized_data' => array(
                    array(
                        'path' => _PS_ROOT_DIR_ . '/upload/',
                        'field' => 'value',
                    )
                ),
            );
        }
        return $entity ? (isset($this->struct_files[$entity]) ? $this->struct_files[$entity] : array()) : $this->struct_files;
    }

    public static function getInstance()
    {
        if (!self::$_INSTANCE) {
            self::$_INSTANCE = new MCDefines();
        }
        return self::$_INSTANCE;
    }

}