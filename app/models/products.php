<?php


namespace MVC\Models;


class Products extends AbstractModel
{
    public $id;
    public $img;
    public $price;
    public $name;
    public $description;
    public $categories = array();
    public $sizes = array();
    public $discount = array();
    public $wanted_language = 'en';

    public static $tableName = 'products';
    public static $primaryKey = 'id';
    public static $tableSchema = [
        'img'   =>  self::DATA_TYPE_STR,
        'price'   =>  self::DATA_TYPE_FLOAT
    ];


    public function getProductData($id = '')
    {
        if($id != '' && $id != false){
            $prod = SELF::getByPK($id);

            $this->id = $prod->id;
            $this->img = $prod->img;
            $this->price = $prod->price;
        }

    }

    public function getProductFullData(){
        $prod = new Langproduct($this->wanted_language);
        $prod = $prod::getByPK($this->id);

        $this->name = $prod->name;
        $this->description = $prod->description;
    }

    public function getProductCatagory(){
        $prod = new Prod_cat();
        $prod = $prod::getByPK($this->id,'y');

        if($prod != false){
            foreach ($prod as $item) {

                $category = Category::getByPK($item->cateId);
                $name = $this->wanted_language . '_catagory';

                $category = ['id' => $category->id, 'category' => $category->$name];
                array_push($this->categories, $category);
            }
        }
    }

    public function getProductSizes()
    {
        $prod = Prod_size::getByPK($this->id,'y');
        if ($prod != false)
        {
            foreach ($prod as $item) {
                $size = Sizes::getByPK($item->sizeId);
                $name = $this->wanted_language.'_size';

                $size = ['id' => $size->id, 'size' => $size->$name];
                array_push($this->sizes,$size);

            }
        }
    }

    public function getProductDiscounts()
    {
        $prod = Prod_disc::getByPK($this->id,'y');
        if ($prod != false)
        {
            foreach ($prod as $item)
            {
                $disc = Discount::getByPK($item->discId);

                $discount = ['id' => $disc->id,'amount' => $disc->discount,'type' =>  $disc->discount_type];
                array_push($this->discount,$discount);
            }
        }
    }

    public function returnData($str)
    {
        //FullData, Category, Sizes, Discount

        $str = explode(',',$str);

        $this->getProductData();

        $output = [
            "id"    =>  $this->id,
            "img"   =>  $this->img,
            "price" =>  $this->price
        ];

        if(array_search('FullData',$str) !== false){
            $this->getProductFullData();
            $arr = [
                'product_data' => [
                    "name"  =>  $this->name,
                    "description"   =>  $this->description
                ]
            ];
            $output = array_merge($output,$arr);
        }
        if(array_search('Category',$str) !== false){
            $this->getProductCatagory();
            $arr = [
                'categories' =>  $this->categories
            ];
            $output = array_merge($output,$arr);
        }
        if(array_search('Sizes',$str) !== false){
            $this->getProductSizes();
            $arr = [
                'sizes'     =>  $this->sizes
            ];
            $output = array_merge($output,$arr);
        }
        if(array_search('Discount',$str) !== false){
            $this->getProductDiscounts();
            $arr = [
                'discounts'     =>  $this->discount
            ];
            $output = array_merge($output,$arr);
        }

        return $output;
    }

    public static function getByCategory($cateId,$limit_start = 0,$limit_end = 0){
        $data = Prod_cat::getByCateId($cateId,$limit_start,$limit_end);

        $prod_ids = $data;
        $prod = [];

        $x = 1;
        foreach ($prod_ids as $prod_id){
            if ($limit_end != 0){
                if ($x == $limit_end + 1) {
                    break;
                }
            }
            $pro = Products::getByPK($prod_id->prodId);
            array_push($prod,$pro);
            $x++;
        }

        return $prod;
    }
}