# Huong Dan Su Dung Admin Panel

## Dang Nhap
- URL: `/login`
- Tai khoan admin: Email co role = 'admin' trong database
- Sau khi dang nhap, se duoc chuyen den trang admin dashboard

## Cac Chuc Nang

### 1. Dashboard (`/admin`)
- Thong ke tong quan: users, products, categories, orders
- Thong ke don hang: cho xu ly, hoan thanh, doanh thu
- Hanh dong nhanh: them product, category, xem orders
- Don hang gan day: 5 don hang moi nhat
- San pham ban chay: 5 san pham co nhieu order nhat

### 2. Quan Ly Danh Muc (`/admin/categories`)

#### Danh sach (`/admin/categories`)
- Hien thi tat ca danh muc voi so luong san pham
- Trang thai: Hoat dong / Khóa
- Action: Xem, Sua, Xoa
- **Luu y:** Khong xoa duoc danh muc co san pham

#### Tao moi (`/admin/categories/create`)
- Ten danh muc (bat buoc)
- Mo ta (khong bat buoc)
- Hinh anh (bat buoc)
- Trang thai (mac dinh la hoat dong)
- Slug tu dong tao tu ten

#### Sua (`/admin/categories/edit/{id}`)
- Giong form Tao moi
- Co the thay doi hinh anh
- Hien thi hinh anh hien tai

#### Chi tiet (`/admin/categories/show/{id}`)
- Thong tin chi tiet danh muc
- Danh sach san pham trong danh muc (10 dau tien)
- Thong ke so luong san pham

### 3. Quan Ly San Pham (`/admin/products`)

#### Danh sach (`/admin/products`)
- Hien thi tat ca san pham
- Thong tin: ten, danh muc, gia, ton kho, trang thai
- Action: Xem, Sua, Xoa

#### Tao moi (`/admin/products/create`)
- Ten san pham (bat buoc)
- Danh muc (bat buoc - chon tu danh muc dang hoat dong)
- Mo ta chi tiet
- Gia (VND) (bat buoc)
- So luong ton kho (bat buoc)
- Hinh anh (bat buoc)

#### Sua (`/admin/products/edit/{id}`)
- Giong form Tao moi
- Co the thay doi hinh anh
- Hien thi hinh anh hien tai

#### Chi tiet (`/admin/products/show/{id}`)
- Thong tin chi tiet san pham
- Thong ke: so lan da ban, tong doanh thu
- Lich su don hang chua san pham nay

### 4. Quan Ly Don Hang (`/admin/orders`)

#### Danh sach (`/admin/orders`)
- Hien thi tat ca don hang
- Thong tin: ma don, khach hang, tong tien, trang thai
- Trang thai: Cho xu ly, Hoan thanh, Da huy
- Action: Xem, Sua, Xoa

#### Tao moi (`/admin/orders/create`)
- Chon khach hang
- Them nhieu san pham:
  - Chon san pham tu danh sach
  - Nhap so luong
  - He thong tu dong kiem tra ton kho
  - Tinh tong gia tu dong
- **Luu y:** Ton kho se giam sau khi tao don hang thanh cong

#### Sua (`/admin/orders/edit/{id}`)
- Chi co the sua trang thai don hang
- Khong the sua san pham sau khi da tao

#### Chi tiet (`/admin/orders/show/{id}`)
- Thong tin chi tiet don hang
- Thong tin khach hang
- Chi tiet san pham: so luong, gia, thanh tien
- Tong cong

### 5. Quan Ly Nguoi Dung (`/admin/users`)

#### Danh sach (`/admin/users`)
- Hien thi tat ca nguoi dung
- Thong tin: ten, email, dien thoai, vai tro
- Vai tro: Admin, User
- Action: Xem, Sua, Xoa
- **Luu y:** Khong xoa duoc user co don hang

#### Tao moi (`/admin/users/create`)
- Ho ten (bat buoc)
- Email (bat buoc, unique)
- Mat khau (bat buoc, toi thieu 6 ky tu)
- Dien thoai
- Dia chi
- Vai tro (bat buoc)

#### Sua (`/admin/users/edit/{id}`)
- Giong form Tao moi
- Mat khau: de trong neu khong muon doi
- Email khong the trung voi user khac

#### Chi tiet (`/admin/users/show/{id}`)
- Thong tin chi tiet nguoi dung
- Lich su don hang (5 don hang dau tien)
- Thong tin tai khoan

## Validation & Error Handling

### Validation Rules:
- **Category:** Ten bat buoc, unique, hinh anh bat buoc
- **Product:** Ten bat buoc, gia >= 0, stock >= 0, category bat buoc
- **Order:** User bat buoc, it nhat 1 san pham, quantity >= 1
- **User:** Ten bat buoc, email unique, mat khau >= 6 ky tu

### Error Messages:
- Tat ca error messages deu bang tieng Viet
- Hien thi form validation errors
- Flash messages cho success/error

### Security:
- Admin middleware bao ve tat ca routes admin
- Hashed passwords
- SQL injection prevention qua Eloquent
- CSRF protection

## File Uploads

- **Location:** `public/uploads/`
- **Categories:** `public/uploads/categories/`
- **Products:** `public/uploads/products/`
- **Max size:** 2MB
- **Allowed formats:** jpeg, jpg, png, gif, webp
- **Auto cleanup:** Xoa file cu khi cap nhat/xoa

## Stock Management

- Kiem tra ton kho khi tao don hang
- Giam ton kho tu dong khi tao don hang
- Khoi phuc ton kho khi xoa don hang (chua cancel)
- Hien thi trang thai "Het Hang" khi stock = 0

## Tips

1. **Backup:** Luon backup truoc khi xoa du lieu
2. **Stock:** Kiem tra stock truoc khi tao don hang lon
3. **Images:** Nen toi uu hinh anh truoc khi upload
4. **Users:** Chi tao admin account cho nguoi tin cay
5. **Testing:** Test tat ca flow truoc khi production

## Troubleshooting

### Image khong hien thi:
- Kiem tra thu muc `public/uploads/` da duoc tao
- Chay `php artisan storage:link`
- Kiem tra permissions

### Error 403:
- Kiem tra user role = 'admin'
- Kiem tra middleware dang chay

### Stock khong dung:
- Kiem tra transaction da commit
- Kiem tra error messages trong log
