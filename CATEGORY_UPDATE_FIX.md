# Cai Thien Logic Sua Danh Muc - Chi File Upload

## Yêu Cau Môi:
- **Bô chuc nang URL hình anh**
- **Chi giu lai chon file tu thu muc**

## Cac Sûa Da Thuc Hien:

### CategoryController.php

#### 1. Store Method
```php
// SAU
'image' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:2048'
```

**Thay doi:**
- Bõ validation `image_url`
- Giu lai `image` required
- Giu lai logic upload file

#### 2. Update Method
```php
// SAU  
'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048'
```

**Thay doi:**
- Bõ validation `image_url`
- Giu lai `image` nullable
- Bõ logic xû ly URL
- Giu lai logic upload file

### Views

#### 1. create.blade.php
**Bõ:**
- Field `image_url` input
- Error message cho `image_url`
- Giu lai `required` attribute

#### 2. edit.blade.php  
**Bõ:**
- Field `image_url` input
- Text "Hoac nhap URL hinh anh moi"
- Error message cho `image_url`

## Logic Hoat Dong Môi:

### Tao Category Moi:
1. **File Upload (Bât Buoc):** Chon file -> Upload -> `uploads/categories/`
2. **Validation:** Phai chon file anh
3. **Error:** Hien thi neu không chon file

### Sua Category:
1. **Giu nguyen:** Neu không chon file moi
2. **File Upload (Optional):** Xóa file cu -> Upload file moi
3. **Validation:** File optional, validate neu co

## Error Messages:
- `image.required`: "Vui lòng chon hinh anh"
- `image.image`: "File duoc chon khong phai la hinh anh"
- `image.mimes`: "Hinh anh phai co dinh dang: jpeg, jpg, png, gif, webp"
- `image.max`: "Kich thuoc hinh anh khong duoc vuot qua 2MB"

## File Management:
- **Local files:** Luu trong `public/uploads/categories/`
- **Cleanup:** Xóa file cu khi upload file moi
- **Backup:** Giu lai file cu khi không thay doi

## Test Cases:
1. [ ] Tao category voi file upload (bât buoc)
2. [ ] Tao category không chon file -> error
3. [ ] Sua category: giu nguyen anh
4. [ ] Sua category: upload file moi
5. [ ] Validation: file không dung dinh dang -> error
6. [ ] Validation: file qua 2MB -> error
7. [ ] Frontend: hien thi anh dung

## Kêt Qua:
- **Simple:** Chi file upload, không URL
- **Consistent:** Validation dong bo giua create/update
- **User-friendly:** Error messages tieng Viet ro rang
- **Data integrity:** Tu dong cleanup file không dung
- **Secure:** Chi upload file, không có URL bên ngoài
