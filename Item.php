<?php
    include_once(__DIR__."/Db.php");
    class Item
    {
        private string $name;
        private string $description;
        private string $image;
        private float $price;
        private string $category;
        private string $subcategory;

        // Getter and setter for Name
        public function getName(): string
        {
            return $this->name;
        }

        public function setName(string $name): void
        {
            if (empty($name)) {
                throw new InvalidArgumentException("Name cannot be empty.");
            }
            $this->name = $name;
        }

        // Getter and setter for Description
        public function getDescription(): string
        {
            return $this->description;
        }

        public function setDescription(string $description): void
        {
            if (empty($description)) {
                throw new InvalidArgumentException("Description cannot be empty.");
            }
            $this->description = $description;
        }

        // Getter and setter for Image
        public function getImage(): string
        {
            return $this->image;
        }

        public function setImage(string $image): void
        {
            if (empty($image)) {
                throw new InvalidArgumentException("Image cannot be empty.");
            }
            $this->image = $image;
        }

        // Getter and setter for Price
        public function getPrice(): float
        {
            return $this->price;
        }

        public function setPrice(float $price): void
        {
            if ($price < 0) {
                throw new InvalidArgumentException("Price cannot be negative.");
            }
            $this->price = $price;
        }

        // Getter and setter for Category
        public function getCategory(): string
        {
            return $this->category;
        }

        public function setCategory(string $category): void
        {
            $this->category = $category;
        }

        // Getter and setter for Subcategory
        public function getSubcategory(): string
        {
            return $this->subcategory;
        }

        public function setSubcategory(string $subcategory): void{
            $this->subcategory = $subcategory;
        }

        public function save(){
            $conn = Db::getConnection();

            $query = $conn->prepare("INSERT INTO `products` (`title`, `price`, `description`, `img`, `category`, `subcategory`) VALUES (:name, :price, :desc, :img, :category, :subcategory)");
            $name = $this->getName();
            $price = $this->getPrice();
            $desc = $this->getDescription();
            $img = $this->getImage();
            $category = $this->getCategory();
            $subcategory = $this->getSubcategory();

            $query->bindValue(":name", $name);
            $query->bindValue(":price", $price);
            $query->bindValue(":desc", $desc);
            $query->bindValue(":img", $img);
            $query->bindValue(":category", $category);  
            $query->bindValue(":subcategory", $subcategory);  


            $result = $query->execute();
            return $result;
        }

        public static function getAll(){
            $conn = Db::getConnection();
            $query = $conn->prepare("SELECT * FROM products");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC); 
        }

        public static function getByID(int $ID) {
            $conn = Db::getConnection();
            $query = $conn->prepare("SELECT * FROM products WHERE ID=:ID");
            $query->bindValue(":ID", $ID);
            $query->execute();
            $product = $query->fetch(PDO::FETCH_ASSOC);
            return $product;
        }

        public static function deleteItem(int $ID) {
            $conn = Db::getConnection();
            $query = $conn->prepare("DELETE FROM products WHERE ID=:ID");
            $query->bindValue(":ID", $ID);
            $query->execute();
        }

        public function update($ID){
            $conn = Db::getConnection();

            $query = $conn->prepare("UPDATE products SET title = :name, price = :price, description = :desc, img = :img, category = :category, subcategory = :subcategory WHERE ID = :ID;");
            $name = $this->getName();
            $price = $this->getPrice();
            $desc = $this->getDescription();
            $img = $this->getImage();
            $category = $this->getCategory();
            $subcategory = $this->getSubcategory();

            $query->bindValue(":ID", $ID);
            $query->bindValue(":name", $name);
            $query->bindValue(":price", $price);
            $query->bindValue(":desc", $desc);
            $query->bindValue(":img", $img);
            $query->bindValue(":category", $category);  
            $query->bindValue(":subcategory", $subcategory);  


            $result = $query->execute();
            return $result;
        }

        public static function searchProduct($search) {
            $conn = Db::getConnection();
            $query = $conn->prepare("SELECT * FROM products WHERE title LIKE :search OR description LIKE :search;");
            $searchPattern = '%' . $search . '%';
            $query->bindValue(":search", $searchPattern);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function processImage(){
            if (isset($_FILES['img']) && $_FILES['img']['error'] == UPLOAD_ERR_OK) {
                // Define the upload directory (ensure it exists)
                $uploadDir = 'uploads/'; // Folder inside the same directory as upload.php
                
                // Ensure the directory exists
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true); // Create the directory if it doesn't exist
                }
        
                // Get file info
                $fileName = basename($_FILES['img']['name']);
                $fileTmpName = $_FILES['img']['tmp_name'];
                $fileSize = $_FILES['img']['size'];
                $fileError = $_FILES['img']['error'];
                $fileType = $_FILES['img']['type'];
        
                // Validate file type (optional, e.g., only allow images)
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (in_array($fileType, $allowedTypes)) {
                    // Generate a unique filename to avoid overwriting
                    $newFileName = uniqid() . '-' . $fileName;
        
                    // Define the full path to move the file
                    $uploadPath = $uploadDir . $newFileName;
        
                    // Move the file to the 'uploads' directory
                    if (move_uploaded_file($fileTmpName, $uploadPath)) {
                        // Generate the image URL (relative path)
                        $imgURL = $uploadDir . $newFileName; // This is the URL
        
                        
                    } else {
                        echo "Error: Failed to move the uploaded file.";
                    }
                } else {
                    echo "Error: Invalid file type. Only JPG, PNG, and GIF files are allowed.";
                }
            } else {
                echo "Error: No file uploaded or there was an upload error.";
            }
            return $imgURL;
        }
    }
?>