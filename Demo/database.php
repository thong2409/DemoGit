<?php
class Database
{
    private $host = "localhost"; // Địa chỉ máy chủ cơ sở dữ liệu
    private $username = "root"; // Tên người dùng cơ sở dữ liệu
    private $password = ""; // Mật khẩu cơ sở dữ liệu
    private $database = "shop"; // Tên cơ sở dữ liệu
    private $conn;

    // Hàm khởi tạo, tự động mở kết nối khi khởi tạo đối tượng
    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Hàm thực thi truy vấn SELECT và trả về kết quả
    public function query($sql)
    {
        $result = $this->conn->query($sql);
        if (!$result) {
            die("Query failed: " . $this->conn->error);
        }
        return $result;
    }

    public function prepare($sql)
    {
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Statement preparation failed: " . $this->conn->error);
        }
        return $stmt;
    }
    // Hàm thực thi truy vấn INSERT, UPDATE hoặc DELETE
    public function execute($sql)
    {
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            die("Error executing query: " . $this->conn->error);
        }
    }

    // Đóng kết nối cơ sở dữ liệu
    public function close()
    {
        $this->conn->close();
    }
}
