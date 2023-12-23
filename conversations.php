<?php
include_once("db.php"); // Include the file with the Database class

class Conversations {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data) {
        try {
            // Prepare the SQL INSERT statement
            $sql = "INSERT INTO ai_conversations(ai_used, conversation_name, access_level, created_by, created_on, description) 
            VALUES(:ai_used, :conversation_name, :access_level, :created_by, sysdate(), :description);";
            $stmt = $this->db->getConnection()->prepare($sql);

            // Bind values to placeholders
            $stmt->bindParam(':ai_used', $data['ai_used']);
            $stmt->bindParam(':conversation_name', $data['conversation_name']);
            $stmt->bindParam(':access_level', $data['access_level']);
            $stmt->bindParam(':created_by', $data['created_by']);
            $stmt->bindParam(':description', $data['description']);

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

            $sql = "SELECT * FROM mydb.ai_conversations WHERE id = :id";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            // Fetch the student data as an associative array
            $convoData = $stmt->fetch(PDO::FETCH_ASSOC);

            return $convoData;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    public function update($id, $data) {
        try {
            $sql = "UPDATE ai_conversations SET
                    ai_used = :ai_used,
                    conversation_name = :conversation_name,
                    access_level = :access_level,
                    created_by = :created_by,
                    created_on = :created_on,
                    description = :description
                    WHERE id = :id";

            $stmt = $this->db->getConnection()->prepare($sql);
            // Bind parameters
            $stmt->bindParam(':id', $data['id']);
            $stmt->bindParam(':ai_used', $data['ai_used']);
            $stmt->bindParam(':conversation_name', $data['conversation_name']);
            $stmt->bindParam(':access_level', $data['access_level']);
            $stmt->bindParam(':created_by', $data['created_by']);
            $stmt->bindParam(':created_on', $data['created_on']);
            $stmt->bindParam(':description', $data['description']);

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
            $sql = "DELETE FROM ai_conversations WHERE id = :id";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            // Check if any rows were affected (record deleted)
            if ($stmt->rowCount() > 0) {
                return true; // Record deleted successfully
            } else {
                return false; // No records were deleted (student_id not found)
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    // public function displayAll(){
    //     try {
    //         $sql = "SELECT *
    //         FROM ai_conversations c
    //         ORDER BY c.id ASC
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
            $sql = "SELECT ai_conversations.id, artificial_intelligence_used.name AS 'A.I Used', conversation_name AS 'Conversation Name', access_level.level AS 'Access Level', concat(employees.first_name, ' ', employees.middle_name, ' ', employees.last_name) AS 'Created By', created_on AS 'Created On', description AS Description 
                    FROM ai_conversations
                    INNER JOIN artificial_intelligence_used
                    ON ai_conversations.ai_used = artificial_intelligence_used.id
                    INNER JOIN access_level
                    ON ai_conversations.access_level = access_level.id
                    INNER JOIN employees
                    ON created_by = employees.idemployees
                    WHERE access_level <> 3
                    ORDER BY id ASC;
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
            $sql = "SELECT COUNT(*) as total FROM ai_conversations";
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
    
    /*private convos */

    public function p_displayPage($startIndex, $resultsPerPage) {
        try {
            $sql = "SELECT ai_conversations.id, artificial_intelligence_used.name AS 'A.I Used', conversation_name AS 'Conversation Name', access_level.level AS 'Access Level', concat(employees.first_name, ' ', employees.middle_name, ' ', employees.last_name) AS 'Created By', created_on AS 'Created On', description AS Description 
                    FROM ai_conversations
                    INNER JOIN artificial_intelligence_used
                    ON ai_conversations.ai_used = artificial_intelligence_used.id
                    INNER JOIN access_level
                    ON ai_conversations.access_level = access_level.id
                    INNER JOIN employees
                    ON created_by = employees.idemployees
                    WHERE access_level = 3
                    ORDER BY id ASC;
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
    public function p_countAll() {
        try {
            $sql = "SELECT COUNT(*) as total FROM ai_conversations WHERE access_level = 3";
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