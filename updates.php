<?php
include_once("db.php"); // Include the file with the Database class

class Updates {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data) {
        try {
            // Prepare the SQL INSERT statement
            $sql = "INSERT INTO conversations_updates(conversation_id, updated_by, updated_on, updates_implemented) 
            VALUES(:conversation_id, :updated_by, sysdate(), :updates_implemented);";
            $stmt = $this->db->getConnection()->prepare($sql);

            // Bind values to placeholders
            $stmt->bindParam(':conversation_id', $data['conversation_id']);
            $stmt->bindParam(':updated_by', $data['updated_by']);
            $stmt->bindParam(':updates_implemented', $data['updates_implemented']);

            // Execute the INSERT query
            $stmt->execute();

            // Check if the insert was successful
             
            if($stmt->rowCount() > 0)
            {
                return $this->db->getConnection()->lastInsertId();
            }

        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    public function read($id) {
        try {
            $connection = $this->db->getConnection();

            $sql = "SELECT * FROM mydb.conversations_updates WHERE id = :id";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            // Fetch the student data as an associative array
            $updateData = $stmt->fetch(PDO::FETCH_ASSOC);

            return $updateData;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    public function update($id, $data) {
        try {
            $sql = "UPDATE conversations_updates SET
                    conversation_id = :conversation_id,
                    updated_by = :updated_by,
                    updated_on = :updated_on,
                    updates_implemented = :updates_implemented
                    WHERE id = :id";

            $stmt = $this->db->getConnection()->prepare($sql);
            // Bind parameters
            $stmt->bindParam(':id', $data['id']);
            $stmt->bindParam(':conversation_id', $data['conversation_id']);
            $stmt->bindParam(':updated_by', $data['updated_by']);
            $stmt->bindParam(':updated_on', $data['updated_on']);
            $stmt->bindParam(':updates_implemented', $data['updates_implemented']);

            // Execute the query
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    public function delete($id) {
        try {
            $sql = "DELETE FROM conversations_updates WHERE id = :id";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            // Check if any rows were affected (record deleted)
            if ($stmt->rowCount() > 0) {
                return true; // Record deleted successfully
            } else {
                return false; // No records were deleted (conversations_updates.id not found)
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    // public function displayAll(){
    //     try {
    //         $sql = "SELECT *
    //         FROM conversations_updates u
    //         ORDER BY u.id DESC
    //         LIMIT 20";
    //         $stmt = $this->db->getConnection()->prepare($sql);
    //         $stmt->execute();
    //         $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //         return $result;
    //     } catch (PDOException $e) {
    //         // Handle any potential errors here
    //         echo "Error: " . $e->getMessage();
    //         throw $e; // Re-throw the exception for higher-level handling
    //     }
    // }
    public function displayPage($startIndex, $resultsPerPage) {
        try {
            $sql = "SELECT * FROM conversations_updates
                    ORDER BY id ASC 
                    LIMIT :startIndex, :resultsPerPage";
    
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam(':startIndex', $startIndex, PDO::PARAM_INT);
            $stmt->bindParam(':resultsPerPage', $resultsPerPage, PDO::PARAM_INT);
            $stmt->execute();
    
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $result;
        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }
    public function countAll() {
        try {
            $sql = "SELECT COUNT(*) as total FROM conversations_updates";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute();
    
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['total'];
        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }    
}
?>