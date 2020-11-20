# abc_rest
Proje XAMMP kullanılarak yapıldı.Uygulama için Symfony 4.4 versiyonu kullanıldı.
Database adı olarak Orders ve tablo adları olarak users ve orders olarak tanımlama yapılmıştır.
Restapi için istenen servis ve requestler için postman collection oluşturulmuştur.

Proje için önce users tablosunda kullanıcıların tanımlanması gerekir.(Postman içinde User Registry'ye requestiyle tanımlanabilir.)

Yapılacak diğer tüm requestler için kayıtlı kullanıcı ile login olunup jtw token oluşturulması ve bu tokenın diğer requestlerde Authorization kısmında bearer token 
olarak tanımlanması gerekir.

Login olup jtw token alınması için gereken.(Postman içinde User Login requestiyle alınabilir.)

Sipariş oluşturmak için gereken.(Postman içinde Add Order requestiyle oluşturulabilir.)

Tüm siparişleri listelemek için gereken.(Postman içinde List Order requestiyle listelenebilir.)

Tek bir siparişi göstermek için gereken.(Postman içinde Show Order requestiyle listelenebilir.)

Siparişi güncellemek için gereken.(Postman içinde Order Update requestiyle güncellenebilir. Sipariş için oluşturulan shippingdate bugünden küçük değilse güncelleme yapılmayacaktır)

Sipariş silmek için gereken.(Postman içinde Order Delete requestiyle silinebilir.)

Siparişler için Add,Show,Update,Delete requestlerinde o sipariş için otomatik oluşturulan ve veritabanında orders tablosunda tutulan siparişe ait orderCode'un 
requestin url'sinin sonana eklenmelidir.



