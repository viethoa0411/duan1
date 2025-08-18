<?php

class AdminProduct
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }


    public function getTotalProducts()
    {
        $sql = "SELECT COUNT(*) AS total FROM products";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function getAllProduct($keyword = '')
    {
        try {
            $sql = "SELECT p.*, 
                       c.name AS category_name,
                       COALESCE(SUM(pv.stock), 0) AS total_stock
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN product_variants pv ON p.id = pv.product_id
                WHERE 1";

            // Nếu có từ khóa thì thêm điều kiện tìm kiếm
            if (!empty($keyword)) {
                $sql .= " AND (p.name LIKE :keyword OR c.name LIKE :keyword)";
            }

            $sql .= " GROUP BY p.id, c.name
                  ORDER BY p.updated_at DESC";

            $stmt = $this->conn->prepare($sql);

            if (!empty($keyword)) {
                $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi truy vấn: " . $e->getMessage();
            return false;
        }
    }



    public function addProduct(
        $name,
        $price,
        $price_sale,
        $description,
        $image,
        $image_list,
        $created_at,
        $updated_at,
        $category_id
    ) {
        try {
            $sql = 'INSERT INTO `products` 
            (`name`, `price`, `price_sale`, `description`, `image`, `image_list`, `created_at`, `updated_at`, `category_id`) 
            VALUES 
            (:name, :price, :price_sale, :description, :image, :image_list, :created_at, :updated_at, :category_id)';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':price' => $price,
                ':price_sale' => $price_sale,
                ':description' => $description,
                ':image' => $image,
                ':image_list' => $image_list,
                ':created_at' => $created_at,
                ':updated_at' => $updated_at,
                ':category_id' => $category_id
            ]);

            return $this->conn->lastInsertId();
        } catch (Exception $e) {
            echo "Lỗi thêm sản phẩm: " . $e->getMessage();
            return false;
        }
    }

    public function addProductVariants($product_id, $size_id, $color_id, $stock)
    {
        try {
            // Kiểm tra xem biến thể đã tồn tại chưa
            $checkSql = 'SELECT id, stock FROM product_variants 
                     WHERE product_id = :product_id 
                     AND size_id = :size_id 
                     AND color_id = :color_id';
            $checkStmt = $this->conn->prepare($checkSql);
            $checkStmt->execute([
                ':product_id' => $product_id,
                ':size_id' => $size_id,
                ':color_id' => $color_id
            ]);

            $variant = $checkStmt->fetch(PDO::FETCH_ASSOC);

            if ($variant) {
                // Nếu đã có → cập nhật stock
                $updateSql = 'UPDATE product_variants 
                          SET stock = stock + :stock 
                          WHERE id = :id';
                $updateStmt = $this->conn->prepare($updateSql);
                $updateStmt->execute([
                    ':stock' => (int)$stock,
                    ':id' => $variant['id']
                ]);
            } else {
                // Nếu chưa có → thêm mới
                $insertSql = 'INSERT INTO product_variants (product_id, size_id, color_id, stock) 
                          VALUES (:product_id, :size_id, :color_id, :stock)';
                $insertStmt = $this->conn->prepare($insertSql);
                $insertStmt->execute([
                    ':product_id' => $product_id,
                    ':size_id' => $size_id,
                    ':color_id' => $color_id,
                    ':stock' => (int)$stock
                ]);
            }

            return true;
        } catch (Exception $e) {
            echo "Lỗi thêm/cập nhật biến thể: " . $e->getMessage();
            return false;
        }
    }

    public function getSizesByProductId($productId)
    {
        $sql = "SELECT DISTINCT s.id, s.name AS size_name
            FROM product_variants pv
            JOIN sizes s ON pv.size_id = s.id
            WHERE pv.product_id = :product_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':product_id' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getColorsByProductId($productId)
    {
        $sql = "SELECT DISTINCT c.id, c.name AS color_name
            FROM product_variants pv
            JOIN colors c ON pv.color_id = c.id
            WHERE pv.product_id = :product_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':product_id' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getTotalStockByProductId($product_id)
    {
        $sql = "SELECT SUM(stock) as total_stock 
            FROM product_variants 
            WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':product_id' => $product_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_stock'] ?? 0;
    }

    public function getVariantsByProductId($product_id)
    {
        $sql = "SELECT pv.id, pv.stock, 
                   s.name AS size_name, 
                   c.name AS color_name
            FROM product_variants pv
            INNER JOIN sizes s ON pv.size_id = s.id
            INNER JOIN colors c ON pv.color_id = c.id
            WHERE pv.product_id = :product_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':product_id' => $product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function getAllSizes()
    {
        $sql = "SELECT id, name FROM sizes ORDER BY name ASC";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllColors()
    {
        $sql = "SELECT id, name FROM colors ORDER BY name ASC";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id)
    {
        try {
            $sql = "SELECT products.*, categories.name AS category_name
                    FROM products
                    LEFT JOIN categories ON products.category_id = categories.id
                    WHERE products.id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi truy vấn bị sai: " . $e->getMessage();
            return false;
        }
    }

    public function updateProduct($id, $name, $price, $price_sale, $quantity, $image, $image_list, $updated_at, $category_id, $description)
    {
        try {
            $sql = "UPDATE products SET 
                        name = :name,
                        price = :price,
                        price_sale = :price_sale,
                        quantity = :quantity,
                        description = :description,
                        image = :image,
                        image_list = :image_list,
                        updated_at = :updated_at,
                        category_id = :category_id
                    WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':id' => $id,
                ':name' => $name,
                ':price' => $price,
                ':quantity' => $quantity,
                ':price_sale' => $price_sale,
                ':description' => $description,
                ':image' => $image,
                ':image_list' => $image_list,
                ':updated_at' => $updated_at,
                ':category_id' => $category_id,
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi truy vấn bị sai: " . $e->getMessage();
            return false;
        }
    }





    public function deleteProduct($id)
    {
        try {
            $this->conn->beginTransaction();

            // Xóa carts
            $sql_carts = "DELETE FROM carts WHERE product_id = :id";
            $stmt_carts = $this->conn->prepare($sql_carts);
            $stmt_carts->execute([':id' => $id]);

            // Xóa order_item (liên kết trực tiếp)
            $sql_order_item_direct = "DELETE FROM order_item WHERE product_id = :id";
            $stmt_order_item_direct = $this->conn->prepare($sql_order_item_direct);
            $stmt_order_item_direct->execute([':id' => $id]);

            // Xóa order_item (qua variant)
            $sql_order_item_variant = "DELETE oi FROM order_item oi
                                   INNER JOIN product_variants pv ON oi.variant_id = pv.id
                                   WHERE pv.product_id = :id";
            $stmt_order_item_variant = $this->conn->prepare($sql_order_item_variant);
            $stmt_order_item_variant->execute([':id' => $id]);

            // Xóa reviews
            $sql_reviews = "DELETE FROM reviews WHERE product_id = :id";
            $stmt_reviews = $this->conn->prepare($sql_reviews);
            $stmt_reviews->execute([':id' => $id]);

            // Xóa variants
            $sql_variant = "DELETE FROM product_variants WHERE product_id = :id";
            $stmt_variant = $this->conn->prepare($sql_variant);
            $stmt_variant->execute([':id' => $id]);

            // Xóa sản phẩm
            $sql_product = "DELETE FROM products WHERE id = :id";
            $stmt_product = $this->conn->prepare($sql_product);
            $stmt_product->execute([':id' => $id]);

            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            echo "Lỗi khi xoá sản phẩm: " . $e->getMessage();
            return false;
        }
    }
}
