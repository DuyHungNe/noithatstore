# Checklist Kiem Thu Admin CRUD

## Pre-Setup
- [ ] Chay `php artisan migrate`
- [ ] Chay `php artisan storage:link` 
- [ ] Tao thu muc `public/uploads/` va `public/uploads/categories/`, `public/uploads/products/`
- [ ] Tao admin user: `php artisan tinker` -> `User::create(['name'=>'Admin','email'=>'admin@test.com','password'=>bcrypt('password'),'role'=>'admin'])`

## Categories CRUD
### Create
- [ ] Truy cap `/admin/categories/create`
- [ ] Nhap ten danh muc
- [ ] Upload hinh anh (jpg/png, <2MB)
- [ ] Nhap mo ta
- [ ] Check/uncheck "Hoat dong"
- [ ] Submit form
- [ ] Verify: Category duoc tao, hien thi trong danh sach, hinh anh hien thi

### Read
- [ ] View danh sach `/admin/categories`
- [ ] Verify: Hien thi tat ca categories, so luong san pham, trang thai
- [ ] Click "Xem" -> Verify chi tiet category
- [ ] Verify: Thong tin day du, danh sach san pham (neu co)

### Update  
- [ ] Click "Sua" category
- [ ] Doi ten, mo ta, trang thai
- [ ] Upload hinh anh moi (optional)
- [ ] Submit
- [ ] Verify: Category duoc cap nhat, hinh anh moi hien thi

### Delete
- [ ] Click "Xoa" category rong
- [ ] Confirm dialog
- [ ] Verify: Category bi xoa, hinh anh bi xoa
- [ ] Try xoa category co san pham -> Verify error message

## Products CRUD
### Create
- [ ] Truy cap `/admin/products/create`
- [ ] Nhap ten san pham
- [ ] Chon danh muc (tu danh muc hoat dong)
- [ ] Nhap gia (>0)
- [ ] Nhap so luong ton kho (>=0)
- [ ] Upload hinh anh
- [ ] Submit
- [ ] Verify: Product duoc tao, hien thi trong danh sach

### Read
- [ ] View danh sach `/admin/products`
- [ ] Verify: Hien thi tat ca products, category, gia, ton kho
- [ ] Click "Xem" -> Verify chi tiet product
- [ ] Verify: Thong tin day du, thong ke ban hang

### Update
- [ ] Click "Sua" product
- [ ] Doi thong tin, category, gia, stock
- [ ] Upload hinh anh moi (optional)
- [ ] Submit
- [ ] Verify: Product duoc cap nhat

### Delete
- [ ] Click "Xoa" product
- [ ] Confirm dialog
- [ ] Verify: Product bi xoa, hinh anh bi xoa

## Orders CRUD
### Create
- [ ] Truy cap `/admin/orders/create`
- [ ] Chon khach hang
- [ ] Click "+ Them San Pham"
- [ ] Chon san pham, nhap quantity <= stock
- [ ] Verify: Tong gia duoc tinh tu dong
- [ ] Them nhieu san pham
- [ ] Submit
- [ ] Verify: Order duoc tao, stock giam, success message

### Read
- [ ] View danh sach `/admin/orders`
- [ ] Verify: Hien thi tat ca orders, trang thai, tong tien
- [ ] Click "Xem" -> Verify chi tiet order
- [ ] Verify: Thong tin khach hang, chi tiet san pham, tong cong

### Update
- [ ] Click "Sua" order
- [ ] Doi trang thai (pending -> completed -> cancelled)
- [ ] Submit
- [ ] Verify: Order duoc cap nhat

### Delete
- [ ] Click "Xoa" order (status != cancelled)
- [ ] Confirm dialog
- [ ] Verify: Order bi xoa, stock duoc khoi phuc

## Users CRUD
### Create
- [ ] Truy cap `/admin/users/create`
- [ ] Nhap ho ten, email, password (>6 ky tu)
- [ ] Nhap dien thoai, dia chi (optional)
- [ ] Chon vai tro (user/admin)
- [ ] Submit
- [ ] Verify: User duoc tao, password hashed

### Read
- [ ] View danh sach `/admin/users`
- [ ] Verify: Hien thi tat ca users, vai tro
- [ ] Click "Xem" -> Verify chi tiet user
- [ ] Verify: Thong tin day du, lich su don hang

### Update
- [ ] Click "Sua" user
- [ ] Doi thong tin, vai tro
- [ ] Nhap password moi (optional)
- [ ] Submit
- [ ] Verify: User duoc cap nhat

### Delete
- [ ] Click "Xoa" user khong co don hang
- [ ] Confirm dialog
- [ ] Verify: User bi xoa
- [ ] Try xoa user co don hang -> Verify error message

## Error Handling
### Validation Errors
- [ ] Submit form trong -> Verify validation errors
- [ ] Upload file khong dung dinh dang -> Verify error
- [ ] Nhap gia/so luong am -> Verify error
- [ ] Email trung lap -> Verify error

### System Errors
- [ ] Upload file qua 2MB -> Verify error
- [ ] Tao don hang voi quantity > stock -> Verify error
- [ ] Truy cap admin route voi user account -> Verify redirect

## UI/UX
### Vietnamese Language
- [ ] Tat ca labels tieng Viet dung chu
- [ ] Tat ca messages tieng Viet dung chu
- [ ] Khong con loi font tieng Viet

### Responsive Design
- [ ] Test tren mobile
- [ ] Test tren tablet
- [ ] Test tren desktop

### User Experience
- [ ] Loading states hien thi
- [ ] Success/error messages ro rang
- [ ] Confirm dialogs cho cac action nguy hiem
- [ ] Navigation mooth

## Security
### Authentication
- [ ] Admin middleware bao ve routes
- [ ] User khong the truy cap admin
- [ ] Auto redirect khi het session

### Data Integrity
- [ ] Foreign key constraints
- [ ] Stock validation
- [ ] Transaction handling

## Performance
### Database
- [ ] Queries optimized (with, whereHas)
- [ ] Pagination working
- [ ] No N+1 problems

### File Upload
- [ ] Image compression (if needed)
- [ ] File cleanup working
- [ ] Disk space usage reasonable

## Final Checks
- [ ] Dashboard statistics correct
- [ ] All navigation links work
- [ ] Breadcrumb navigation
- [ ] Search/filter functions (if any)
- [ ] Export functions (if any)
- [ ] Log files clean
- [ ] Error monitoring setup
