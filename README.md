# lument_first_api
+) Những điểm khác nhau
	+) lumen cung cấp sẵn các lệnh artisan nhỏ gọn và ít hơn laravel 
		vd:artisan make chỉ có make cho migration và seeder.
	+) Về tổ chức code ban đầu thì tương đối có các file và thư mục giống nhau
	+) Không có file server.php để build 1 server như laravel bằng lệnh php artisan serve
	+) Không có file webpack.mix hỗ trợ Laravel Mix
	+) Không có nhiều các file config riêng về database, mail, v.v...như laravel tất cả gói gọn trong .env
	+) Không có sẵn tự gen APP_KEY hay gen bằng lệnh mà phải tự code console hoặc gen = tay
	+) Router không có set name cho route, không có where validate http params
	+) Tất cả những hành động liên quan đến khai báo middleware, config, alias class, register 1 provider, v.v... đều khai báo sử dụng trong bootstrap/app.php
		Không sử dụng được Facade phải bỏ comment $app->withFacades(); trong bootstrap/app.php
		Model không tự động sử dụng được Eloquent ORM phải bỏ comment $app->withEloquent(); trong bootstrap/app.php
	
+) Kết luận
	+) Do lumen được tạo ra vốn dĩ với tư tưởng là 1 micro framework để tăng performent cho ứng dụng nên hầu hết sẽ lược bỏ hầu hết những instance không cần thiết. Và người dùng cần dùng thì phải tự inject hay regist vào
	+) Đối với lập trình viên
		Tìm hiểu lumen cũng là 1 cách để hiểu rõ và sâu hơn về laravel với những cái có sẵn mà lumen không có từ ban đầu
