# Laravel Blog Servisi

Bu proje, Laravel kullanılarak oluşturulmuş basit bir blog servisidir. Kullanıcılar kayıt olabilir, giriş yapabilir ve postlar ile yorumlar ekleyebilirler. Proje, SQLite veritabanını kullanır ve Sanctum ile kimlik doğrulaması yapılır.

## Özellikler

- Kullanıcı kayıt ve giriş işlemleri
- Post oluşturma, güncelleme, silme ve listeleme
- Yorum oluşturma, güncelleme, silme ve listeleme
- API rate limiting
- Gelen verilerin doğrulaması

## Kurulum

### Gereksinimler

- PHP 8.0 veya üzeri
- Composer
- SQLite

# API Dökümantasyonu

## Kullanıcı (User) Yönetimi:

**Yeni Kullanıcı Kaydı:**
```bash
curl --location --request POST 'http://tech-istanbul-api-gelistirme.test/api/register' \
--header 'Accept: application/json' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--data-urlencode 'name=fake-name' \
--data-urlencode 'email=fake@email.address' \
--data-urlencode 'password=fake-password'
```

**Varolan Kullanıcı ile Oturum Açma:**
```bash
curl --location --request POST 'http://tech-istanbul-api-gelistirme.test/api/login' \
--header 'Accept: application/json' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--data-urlencode 'email=fake@email.address' \
--data-urlencode 'password=fake-password'
```

**Mevcut Kullanıcı Bilgisi:**
```bash
curl --location --request GET 'http://tech-istanbul-api-gelistirme.test/api/v1/user' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer ••••••••••••••••••'
```

**Varolan Kullanıcı ile Oturum Kapama:**
```bash
curl --location --request POST 'http://tech-istanbul-api-gelistirme.test/api/v1/logout' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer ••••••••••••••••••'
```

## Gönderi (Post) Yönetimi:

**Tüm Gönderileri Listele:**
```bash
curl --location --request GET 'http://tech-istanbul-api-gelistirme.test/api/v1/posts?page={page_no}' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer ••••••••••••••••••'
```

**Yeni Gönderi Oluştur:**
```bash
curl --location --request POST 'http://tech-istanbul-api-gelistirme.test/api/v1/posts' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--header 'Authorization: Bearer ••••••••••••••••••' \
--data-urlencode 'title=Merhaba' \
--data-urlencode 'body=Bu yeni oluşturulmuş bir gönderi'
```

**Belirli Bir Gönderiyi Görüntüle:**
```bash
curl --location --request GET 'http://tech-istanbul-api-gelistirme.test/api/v1/posts/{post_id}' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer ••••••••••••••••••'
```

**Belirli Bir Gönderiyi Güncelle:**
```bash
curl --location --request PUT 'http://tech-istanbul-api-gelistirme.test/api/v1/posts/{post_id}' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--header 'Authorization: Bearer ••••••••••••••••••' \
--data-urlencode 'title=bu değiştirilmiş bir başlık' \
--data-urlencode 'body=bu da değiştirilmiş bir gönderi' \
```

**Belirli Bir Gönderiyi Sil:**
```bash
curl --location --request DELETE 'http://tech-istanbul-api-gelistirme.test/api/v1/posts/{post_id}' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer ••••••••••••••••••'
```

## Yorum (Comment) Yönetimi:

Tüm Yorumları Listele:
```bash
curl --location --request GET 'http://tech-istanbul-api-gelistirme.test/api/v1/comments?page={page_no}' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer ••••••••••••••••••'
```

Yeni Yorum Oluştur:
```bash
curl --location --request POST 'http://tech-istanbul-api-gelistirme.test/api/v1/comments' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--header 'Authorization: Bearer ••••••••••••••••••' \
--data-urlencode 'post_id=255' \
--data-urlencode 'body=Yeni yapılan bir yorum'
```

Belirli Bir Yorumu Görüntüle
```bash
curl --location --request GET 'http://tech-istanbul-api-gelistirme.test/api/v1/comments/{comment_id}' \
--header 'Authorization: Bearer ••••••••••••••••••'
```

Belirli Bir Yorumu Güncelle
```bash
curl --location --request PUT 'http://tech-istanbul-api-gelistirme.test/api/v1/comments/{comment_id}' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--header 'Authorization: Bearer ••••••••••••••••••' \
--data-urlencode 'body=Bu düzenlenmiş bir yorum'
```

Belirli Bir Yorumu Sil
```bash
curl --location --request DELETE 'http://tech-istanbul-api-gelistirme.test/api/v1/comments/{comment_id}' \
--header 'Authorization: Bearer ••••••••••••••••••'
```
