<?php
// Router - URL routing dengan parameter support
class Router {
    
    // Menyimpan daftar route (GET dan POST)
    private $routes = [];
    
    // Mendaftarkan route dengan method GET
    public function get($path, $callback) { 
        $this->routes['GET'][$path] = $callback; 
    }
    
    // Mendaftarkan route dengan method POST
    public function post($path, $callback) { 
        $this->routes['POST'][$path] = $callback; 
    }
    
    // Menjalankan router
    public function run() {
        
        // Mengambil method request (GET / POST)
        $method = $_SERVER['REQUEST_METHOD'];
        
        // Mengambil URI dari URL
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Menghapus nama file index.php dari path
        $basePath = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
        $uri = str_replace($basePath, '', $uri);
        
        // Normalisasi format URL agar selalu diawali '/'
        $uri = '/' . trim($uri, '/');
        
        // Mengecek apakah ada route untuk method tersebut
        if (isset($this->routes[$method])) {
            
            // Loop semua route yang terdaftar
            foreach ($this->routes[$method] as $route => $callback) {
                
                // Mengubah parameter route menjadi regex
                // Contoh: /buku/{id} -> /buku/([a-zA-Z0-9_-]+)
                $pattern = preg_replace('/\{([a-zA-Z]+)\}/', '([a-zA-Z0-9_-]+)', $route);
                
                // Membuat regex lengkap
                $pattern = '#^' . $pattern . '$#';
                
                // Mengecek apakah URL cocok dengan route
                if (preg_match($pattern, $uri, $matches)) {
                    
                    // Menghapus hasil match pertama (URL lengkap)
                    array_shift($matches);
                    
                    // Jika callback berupa controller dan method
                    if (is_array($callback)) {
                        
                        // Membuat objek controller
                        $controller = new $callback[0]();
                        
                        // Memanggil method controller dengan parameter
                        return call_user_func_array([$controller, $callback[1]], $matches);
                    }
                    
                    // Jika callback berupa function biasa
                    return call_user_func_array($callback, $matches);
                }
            }
        }
        
        // Jika route tidak ditemukan
        http_response_code(404);
        echo "404 - Halaman tidak ditemukan";
    }
}