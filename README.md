Laravel Page Module
===================
[![Laravel 5.1](https://img.shields.io/badge/Laravel-5.1-orange.svg?style=flat-square)](https://laravel.com/docs/5.1/)
[![Source](https://img.shields.io/badge/source-erenmustafaozdal/laravel--page--module-blue.svg?style=flat-square)](https://github.com/erenmustafaozdal/laravel-page-module)
[![License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://tldrlegal.com/license/mit-license)

**Laravel Page Module**, Laravel 5.1 projelerinde *sayfa yönetimi* işlemlerini kapsayan bir modül paketidir. Bu paket kullanıcı arayüzü **(views)** hariç, arka plandaki bütün işlemleri barındırmaktadır. İstersen görünümleri kapsayan [Laravel Modules Core](https://github.com/erenmustafaozdal/laravel-modules-core) paketini kullanarak, modüle tam kapsamıyla sahip olabilirsin.

1. [Kurulum](#kurulum)
    1. [Dosyaların Yayınlanması](#kurulum-dosyalarinYayinlanmasi)
    2. [Migration](#kurulum-migration)
2. [Kullanım](#kullanim)
    1. [Ayar Dosyası](#kullanim-ayarDosyasi)
        1. [Genel Ayarlar](#kullanim-ayarDosyasi-genelAyarlar)
        2. [URL Ayarları](#kullanim-ayarDosyasi-urlAyarlari)
        3. [Controller Ayarları](#kullanim-ayarDosyasi-controllerAyarlari)
        4. [Rota Açıp/Kapatma Ayarları](#kullanim-ayarDosyasi-routeOnOffAyarlari)
        5. [Görünüm Ayarları](#kullanim-ayarDosyasi-gorunumAyarlari)
    2. [Görünüm Tasarlama](#kullanim-gorunumTasarlama)
        1. [Model Kullanımı](#kullanim-gorunumTasarlama-modelKullanimi)
            1. [Page Category](#kullanim-gorunumTasarlama-modelKullanimi-page_category)
            2. [Page](#kullanim-gorunumTasarlama-modelKullanimi-page)
        2. [Rotalar](#kullanim-gorunumTasarlama-rotalar)
            1. [Sayfa Kategori Rotaları](#kullanim-gorunumTasarlama-rotalar-page_category)
            2. [Kategoriye Ait Sayfa Rotaları](#kullanim-gorunumTasarlama-rotalar-category_pages)
            3. [Sayfa Rotaları](#kullanim-gorunumTasarlama-rotalar-page)
        3. [Form Alanları](#kullanim-gorunumTasarlama-formAlanlari)
            1. [Sayfa Kategori Formları](#kullanim-gorunumTasarlama-formAlanlari-page_category)
            2. [Kategoriye Ait Sayfa Formları](#kullanim-gorunumTasarlama-formAlanlari-category_pages)
            3. [Sayfa Formları](#kullanim-gorunumTasarlama-formAlanlari-page)
    3. [Onaylamalar](#kullanim-onaylamalar)
    4. [Olaylar](#kullanim-olaylar)
        1. [Sayfa Kategori Olayları](#kullanim-olaylar-page_category)
        2. [Sayfa Olayları](#kullanim-olaylar-page)
3. [Lisans](#lisans)


<a name="kurulum"></a>
Kurulum
-------
Composer ile yüklemek için aşağıdaki kodu kullanabilirsin.

```bash
composer require erenmustafaozdal/laravel-page-module
```
Ya da `composer.json` dosyana, aşağıdaki gibi ekleme yapıp, paketleri güncelleyebilirsin.
```json
{
    "require": {
        "erenmustafaozdal/laravel-page-module": "~0.1"
    }
}
```

```bash
$ composer update
```
Bu işlem bittikten sonra, service provider'i projenin `config/app.php` dosyasına eklemelisin.

```php
ErenMustafaOzdal\LaravelPageModule\LaravelPageModuleServiceProvider::class,
```
> :exclamation: Eğer **Laravel Modules Core** paketini kullanacaksan, o paketin service provider dosyasını üstte tanımlamalısın.

<a name="kurulum-dosyalarinYayinlanmasi"></a>
##### Dosyaların Yayınlanması
**Laravel Page Module** paketinin dosyalarını aşağıdaki kodla yayınlamalısın.
```bash
php artisan vendor:publish --provider="ErenMustafaOzdal\LaravelPageModule\LaravelPageModuleServiceProvider"
```

<a name="kurulum-migration"></a>
##### Migration
Dosyaları yayınladıktan sonra migration işlemi yapmalısın.

```bash
php artisan migrate
```

> :exclamation: Paket editör aracılığıyla veri tabanına kayıt yapmaktadır. Tahmin edebileceğin gibi Laravel Blade şablonunda `{{ }}` ile html etiketler ekranda metin olarak işlenecektir. Laravel'in `{!! !!}` şeklindeki kullanımı ise; güvenilir olmayan bir kişinin veri kaydetmesi sonucu **XSS** açığı oluşturabilir. Bunun önüne geçmek için **Laravel Page Module** [mewebstudio/Purifier](https://github.com/mewebstudio/Purifier) paketini kullanıyor. Sıradaki işlem olarak **Purifier** paketine yazma izni vermen gerekiyor.

Önce bu paketin dosyalarını yayınlayalım

```bash
php artisan vendor:publish --provider="Mews\Purifier\PurifierServiceProvider"
```

Daha sonra da izni verelim.

```bash
sudo chmod 777 vendor/ezyang/htmlpurifier/library/HTMLPurifier/DefinitionCache/Serializer
```

Son olarak `App\PageCategory` ve `App\Page` modellerini uygun bir şekilde tanımlamalısın. Bunun için `App\PageCategory` modelini `ErenMustafaOzdal\LaravelPageModule\PageCategory` modelinden, `App\Page` modelini `ErenMustafaOzdal\LaravelPageModule\Page` modelinden genişletmelisin.
```php
namespace App;

use ErenMustafaOzdal\LaravelPageModule\PageCategory as EMOPageCategory;

class PageCategory extends EMOPageCategory
{
    //
}
```
```php
namespace App;

use ErenMustafaOzdal\LaravelPageModule\Page as EMOPage;

class Page extends EMOPage
{
    //
}
```

<a name="kullanim"></a>
Kullanım
--------

Kurulum tamamlandığında; [Laravel Modules Core](https://github.com/erenmustafaozdal/laravel-modules-core) paketini de dahil ettiysen, tasarım dahil olarak kullanıma hazır olacaktır.

> :exclamation: metinler yanlış görünüyorsa, [Laravel Modules Core](https://github.com/erenmustafaozdal/laravel-modules-core) paketinin İngilizce dil dosyaları hazır olmadığı içindir. Bu sebeple projenin `config/app.php` dosyasında `'locale' => 'tr'` tanımlaması yapmalısın.

<a name="kullanim-ayarDosyasi"></a>
### Ayar Dosyası

<a name="kullanim-ayarDosyasi-genelAyarlar"></a>
##### Genel Ayarlar
Paketin içinde kullanılan genel ayarlar. Ayar dosyası içinde kök alanda bulunan ayarlar.

| Ayar | Açıklama | Varsayılan Değer |
|---|---|---|
| date_format | Kullanılacak tarih formatı | d.m.Y H:i:s |

<a name="kullanim-ayarDosyasi-urlAyarlari"></a>
##### URL Ayarları
Tarayıcının adres çubuğunda görünecek adreslerin tanımlandığı ayarlar. Ayar dosyasının `url` alanında bulunan ayarlardır.

> Örneğin: `activate_route` ayarı ile aktivasyon sayfası adresi `account-activate` şeklinde tanımlanmıştır. Bu şekilde adres çubuğunda şuna benzer bir görünüm olacaktır: `www.siteadi.com/account-activate/{id}/{code}`

| Ayar | Açıklama | Varsayılan Değer |
|---|---|---|
| page_category | Sayfa Kategorileri sayfa adresi | page-categories |
| page | Sayfaların sayfa adresi | pages |
| admin_url_prefix | Yönetim panelinin adres çubuğundaki ön adı. Örneğin: `www.siteadi.com/admin/pages` | admin |
| middleware | Rotalarda kullanılacak katman filtre sınıfları | ['auth', 'permission'] |

<a name="kullanim-ayarDosyasi-controllerAyarlari"></a>
##### Controller Ayarları
Bazı metotlarda değişiklik yapmak isteyebilirsin. Burada yapacağın tanımlamalarda kendi `Controller` sınıfını tanımlayıp, **Laravel Page Module**'ün ilgili controller'ından genişletirsen, istediğin metotların üzerine yazabilirsin. Ayar dosyasının `controller` alanında bulunan ayarlardır.

| Ayar | Açıklama | Varsayılan Değer |
|---|---|---|
| page_category_admin_namespace | Sayfa Kategorisi yönetim paneli isim uzayı | ErenMustafaOzdal\LaravelPageModule\Http\Controllers |
| page_admin_namespace | Sayfaların yönetim paneli isim uzayı | ErenMustafaOzdal\LaravelPageModule\Http\Controllers |
| page_category_api_namespace | Sayfa Kategorisi api isim uzayı | ErenMustafaOzdal\LaravelPageModule\Http\Controllers |
| page_api_namespace | Sayfaların api isim uzayı | ErenMustafaOzdal\LaravelPageModule\Http\Controllers |
| page_category | Sayfa Kategori Controller | PageCategoryController |
| page | Sayfa Controller | PageController |
| page_category_api | Sayfa Kategori Api Controller | PageCategoryApiController |
| page_api | Sayfa Api Controller | PageApiController |

<a name="kullanim-ayarDosyasi-routeOnOffAyarlari"></a>
##### Rota Açıp/Kapatma Ayarları
Projeye göre bazı rotalar işe yaramayabilir. Bunların açık olmasını istemeyebilirsin. Aşağıdaki ayarları kullanarak istediğin rotaları açıp kapatabilirsin. Ayar dosyasının `routes` alanında bulunan ayarlardır. Bütün rotaların başlangıçta `true` değerine sahiptir ve açıktır.

| Ayar | Açıklama |
|---|---|---|
| admin.page_category | Sayfa Kategorisi yönetim paneli `resource` rotaları |
| admin.page | Sayfa yönetim paneli `resource` rotaları |
| admin.page_publish | Sayfa yayınlama yönetim paneli `get` rotası |
| admin.page_notPublish | Sayfa yayından kaldırma yönetim paneli `get` rotası |
| admin.category_pages | Kategoriye ait sayfaların yönetim paneli `resource` rotaları |
| admin.category_pages_publish | Kategoriye ait sayfaların yayınlama yönetim paneli `get` rotası |
| admin.category_pages_notPublish | Kategoriye ait sayfaların yayından kaldırma yönetim paneli `get` rotası |
| api.page_category | Sayfa Kategorisi api `resource` rotaları |
| api.page_category_models | Sayfa Kategorilerinin çekildiği api `post` rotası (Örneğin **Laravel Modules Core** paketinde *Select2* içine kategoriler çekilirken kullanılıyor) |
| api.page_category_group | Sayfa Kategorilerinin grup olarak işlem yapıldığı api `post` rotası |
| api.page_category_detail | Sayfa Kategorilerinin detay bilgisinin *Datatables* formatında çekildiği api `get` rotası |
| api.page_category_fastEdit | Sayfa Kategorisinin hızlı düzenleme amacıyla çekildiği api `post` rotası |
| api.page | Sayfa api `resource` rotaları |
| api.page_group | Sayfaların grup olarak işlem yapıldığı api `post` rotası |
| api.page_detail | Sayfaların detay bilgisinin *Datatables* formatında çekildiği api `get` rotası |
| api.page_fastEdit | Sayfanın hızlı düzenleme amacıyla çekildiği api `post` rotası |
| api.page_publish | Sayfa yayınlama api `get` rotası |
| api.page_notPublish | Sayfa yayından kaldırma api `get` rotası |
| api.page_contentUpdate | Sayfa içeriğini güncelleme api `post` rotası |
| api.category_pages_index | Kategoriye ait sayfaların çekildiği api `get` rotası |

<a name="kullanim-ayarDosyasi-gorunumAyarlari"></a>
##### Görünüm Ayarları
Paketin kullanacağı görünümlerin tanımlandığı ayarlardır. Ayar dosyasının `views` alanı altında bulunan ayarlardır. Buradaki değerler varsayılan olarak [Laravel Modules Core](https://github.com/erenmustafaozdal/laravel-modules-core) paketinin görünümlerine tanımlıdır.

| Ayar | Açıklama | Varsayılan Değer |
|---|---|---|
| page_category.layout | Sayfa Kategori sayfaları şablon görünümü | laravel-modules-core::layouts.admin |
| page_category.index | Sayfa Kategorilerinin listelendiği sayfanın görünümü | laravel-modules-core::page_category.index |
| page_category.create | Sayfa Kategorisi ekleme sayfasının görünümü | laravel-modules-core::page_category.create |
| page_category.show | Sayfa Kategorisi bilgilerinin olduğu sayfanın görünümü | laravel-modules-core::page_category.show |
| page_category.edit | Sayfa Kategorisi bilgilerinin düzenlendiği sayfanın görünümü | laravel-modules-core::page_category.edit |
| page.layout | Sayfa sayfaları şablon görünümü | laravel-modules-core::layouts.admin |
| page.index | Sayfaların listelendiği sayfanın görünümü | laravel-modules-core::page.index |
| page.create | Sayfa ekleme sayfasının görünümü | laravel-modules-core::page.create |
| page.show | Sayfa bilgilerinin olduğu sayfanın görünümü | laravel-modules-core::page.show |
| page.edit | Sayfa bilgilerinin düzenlendiği sayfanın görünümü | laravel-modules-core::page.edit |


<a name="kullanim-gorunumTasarlama"></a>
### Görünüm Tasarlama
Paket [Laravel Modules Core](https://github.com/erenmustafaozdal/laravel-modules-core) paketiyle beraber direkt kullanıma hazırdır. Ancak istersen kendine özel görünümlerde tasarlayabilirsin. Bu bölüm özel tasarımlar için bir rehberdir.

<a name="kullanim-gorunumTasarlama-modelKullanimi"></a>
##### Model Kullanımı
Görünümler içinde `PageCategory` ve `Page` modellerinin özellik ve metot kullanımı hakkında bilgileri kapsamaktadır. Bu metotlar ve özellikler `App\PageCategory` ve `App\Page` içinde üzerine yazılarak değiştirilebilir.

<a name="kullanim-gorunumTasarlama-modelKullanimi-page_category"></a>
###### Page Category

####### Genel Özellikler
1. **protected $table =** 'page_categories'
2. **protected $fillable =** ['name']
 
####### $page_category->pages `Collection`
`hasMany()` metoduyla `App\Page` modeliyle ilişkiyi sağlar

####### $page_category->name `string`
Baş harfleri büyük formatta sayfa kategorisinin adını döndürür

####### $page_category->created_at `string`
Sayfa kategorisinin kayıt tarihini ayar dosyasındaki tanıma göre döndürür

####### $page_category->created_at_for_humans `string`
Sayfa kategorisinin kayıt tarihini okunaklı veri şeklinde döndürür. Örneğin: *1 hafta önce*

####### $page_category->created_at_table `array`
Sayfa kategorisinin kayıt tarihini `display`(last_login_for_humans) ve `timestamp` şeklinde tutulan bir dizi şeklinde döndürür. Datatable'da kullanılması amacıyla oluşturulmuştur

####### $page_category->updated_at `string`
Sayfa kategorisinin güncellenme tarihini ayar dosyasındaki tanıma göre döndürür

####### $page_category->updated_at_for_humans `string`
Sayfa kategorisinin güncellenme tarihini okunaklı veri şeklinde döndürür. Örneğin: *1 hafta önce*

####### $page_category->updated_at_table `array`
Sayfa kategorisinin güncellenme tarihini `display`(last_login_for_humans) ve `timestamp` şeklinde tutulan bir dizi şeklinde döndürür. Datatable'da kullanılması amacıyla oluşturulmuştur

<a name="kullanim-gorunumTasarlama-modelKullanimi-page"></a>
###### Page

####### Genel Özellikler
1. **protected $table =** 'pages'
2. **protected $fillable =** ['category_id','title','slug','content','description','meta_title','meta_description','meta_keywords','is_publish']
 
####### $page->category `App\PageCategory`
`belongsTo()` metoduyla `App\PageCategory` modeliyle ilişkiyi sağlar

####### $page->title `string`
Baş harfleri büyük formatta sayfa başlığı

####### $page->slug `string`
Sayfa url formatındaki hali

####### $page->content `string`
XSS saldırılarından temizlenmiş sayfa içeriği

####### $page->description `string`
Sayfa açıklaması

####### $page->meta_title `string`
Sayfa meta başlığı

####### $page->meta_description `string`
Sayfa meta açıklaması

####### $page->meta_keywords `string`
Sayfa meta anahtar kelimeleri

####### $page->read `boolean`
Sayfa okunma sayısı *(Geliştirilecek ön yüzde bu değer arttırılıp, gösterilebilir)*

####### $page->is_publish `boolean`
Sayfa yayında mı

####### $page->created_at `string`
Sayfanın kayıt tarihini ayar dosyasındaki tanıma göre döndürür

####### $page->created_at_for_humans `string`
Sayfanın kayıt tarihini okunaklı veri şeklinde döndürür. Örneğin: *1 hafta önce*

####### $page->created_at_table `array`
Sayfanın kayıt tarihini `display`(last_login_for_humans) ve `timestamp` şeklinde tutulan bir dizi şeklinde döndürür. Datatable'da kullanılması amacıyla oluşturulmuştur

####### $page->updated_at `string`
Sayfanın güncellenme tarihini ayar dosyasındaki tanıma göre döndürür

####### $page->updated_at_for_humans `string`
Sayfanın güncellenme tarihini okunaklı veri şeklinde döndürür. Örneğin: *1 hafta önce*

####### $page->updated_at_table `array`
Sayfanın güncellenme tarihini `display`(last_login_for_humans) ve `timestamp` şeklinde tutulan bir dizi şeklinde döndürür. Datatable'da kullanılması amacıyla oluşturulmuştur



<a name="kullanim-gorunumTasarlama-rotalar"></a>
##### Rotalar
**Laravel Page Module** paketi *CRUD* işlemleri için sahip olduğu rotaların dışında, `ajax` ile işlem yapabileceğin birçok rotaya da sahiptir. Görünümlerini tasarlarken bunları kullanabilirsin.

> Rotalarda kullanılabilecek form elemanları bir sonraki bölümde anlatılacaktır.

<a name="kullanim-gorunumTasarlama-rotalar-page_category"></a>
###### Sayfa Kategori Rotaları
Başta sayfa kategorisi CRUD işlemleri olmak üzere, bir kısım *ajax* işlemini de kapsayan rotalar.

| Rota Adı | Açıklama | Tür|
|---|---|---|
| admin.page_category.index | Sayfa kategorilerinin listelendiği sayfa | GET |
| admin.page_category.create | Yeni sayfa kategorilerisi eklendiği sayfa | GET |
| admin.page_category.store | Yeni sayfa kategorilerisi eklendiği sayfadan form verilerinin gönderildiği sayfa | POST |
| admin.page_category.show | Sayfa kategorisi bilgilerinin gösterildiği sayfa. Bu sayfayı oluşturulacak görünümlere `$page_category` değişkeni aktarılır. | GET |
| admin.page_category.edit | Sayfa kategorisi bilgilerinin düzenlendiği sayfa. Bu sayfayı oluşturulacak görünümlere `$page_category` değişkeni aktarılır. | GET |
| admin.page_category.update | Sayfa kategorisi bilgilerinin düzenlendiği sayfadan form verilerinin gönderildiği sayfa | PUT-PATCH |
| admin.page_category.destroy | Sayfa kategorisinin silindiği sayfa | DELETE |
| api.page_category.index | Bu rotada ajax ile Datatable türü veriler çekilir. Gelen sütunlar şunlardır: `id`, `name`, `created_at`, `urls` *(tablonun eylemler sütununda kullanılmak üzere oluşturulmuş bazı adreslerdir.)*. Bütün bunlar dışında `action=filter` verisi ile birlikte; *id*, *name*, *created_at_from* ve *created_at_to* verileri gönderilerek; filtrelenmiş veriler elde edebilirsin | GET |
| api.page_category.store | Yeni sayfa kategorilerisi eklenmesi için verilerin gönderildiği sayfa. | POST |
| api.page_category.update | Sayfa kategorisi bilgilerinin düzenlenmesi için verilerin gönderildiği sayfa. | PUT-PATCH |
| api.page_category.destroy | Sayfa kategorisinin silinmesi için verilerin gönderildiği sayfa | DELETE |
| api.page_category.models | Sayfa kategorisi rollerinin isme veya url tanımlamasına göre filtrelenip döndürüldüğü rota  | POST |
| api.page_category.group | Sayfa kategorileri üzerinde grup işlemleri yapmak için kullanılan bir rota. Silme işlemini destekliyor. `action=destroy` gibi bir veri ile birlikte, dizi içinde işlem yapılacak kullanıcı id'leri gönderilir. Aşağıda veri detayları açıklanmıştır. | POST |
| api.page_category.detail | Sayfa kategorisi id'si iliştirilmiş rota ile kullanıcı *id*, *name*, *updated_at*, *created_at*  bilgileri Datatable formatında gönderilir | GET |
| api.page_category.fastEdit | Hızlı bir şekilde sayfa kategorisi bilgisini düzenlemek için; bilgilerin çekildiği rotadır. Rotaya sayfa kategorisi id'si iliştirilir ve sayfa kategorisi bilgilerinin tamamı çekilir | POST |

<a name="kullanim-gorunumTasarlama-rotalar-category_pages"></a>
###### Kategoriye Ait Sayfa Rotaları
Belirli kategoriye ait sayfaların CRUD işlemleri olmak üzere, bir kısım *ajax* işlemini de kapsayan rotalar.

| Rota Adı | Açıklama | Tür|
|---|---|---|
| admin.page_category.page.index | Belirli kategoriye ait sayfaların listelendiği sayfa | GET |
| admin.page_category.page.create | Belirli kategoriye ait yeni sayfa eklendiği sayfa | GET |
| admin.page_category.page.store | Belirli kategoriye ait yeni sayfa eklendiği sayfadan form verilerinin gönderildiği sayfa | POST |
| admin.page_category.page.show | Belirli kategoriye ait sayfa bilgilerinin gösterildiği sayfa. Bu sayfayı oluşturulacak görünümlere `$page_category` ve `$page` değişkeni aktarılır. | GET |
| admin.page_category.page.edit | Belirli kategoriye ait sayfa bilgilerinin düzenlendiği sayfa. Bu sayfayı oluşturulacak görünümlere `$page_category` ve `$page` değişkeni aktarılır. | GET |
| admin.page_category.page.update | Belirli kategoriye ait sayfa bilgilerinin düzenlendiği sayfadan form verilerinin gönderildiği sayfa | PUT-PATCH |
| admin.page_category.page.destroy | Belirli kategoriye ait sayfanın silindiği sayfa | DELETE |
| admin.page_category.page.publish | Belirli kategoriye ait sayfanın yayınlandığı rota | GET |
| admin.page_category.page.notPublish | Belirli kategoriye ait sayfanın yayından kaldırıldığı rota | GET |
| api.page_category.page.index | Bu rotada ajax ile Datatable türü veriler çekilir. Gelen sütunlar şunlardır: `id`, `category_id`, `slug`, 'title', `is_publish`, `created_at`, `urls` *(tablonun eylemler sütununda kullanılmak üzere oluşturulmuş bazı adreslerdir.)*. Bütün bunlar dışında `action=filter` verisi ile birlikte; *id*, *title*, *slug*, *status*, *created_at_from* ve *created_at_to* verileri gönderilerek; filtrelenmiş veriler elde edebilirsin | GET |

<a name="kullanim-gorunumTasarlama-rotalar-page"></a>
###### Sayfa Rotaları
Sayfaların CRUD işlemleri olmak üzere, bir kısım *ajax* işlemini de kapsayan rotalar.

| Rota Adı | Açıklama | Tür|
|---|---|---|
| admin.page.index | Sayfaların listelendiği sayfa | GET |
| admin.page.create | Yeni sayfa eklendiği sayfa | GET |
| admin.page.store | Yeni sayfa eklendiği sayfadan form verilerinin gönderildiği sayfa | POST |
| admin.page.show | Sayfa bilgilerinin gösterildiği sayfa. Bu sayfayı oluşturulacak görünümlere `$page` değişkeni aktarılır. | GET |
| admin.page.edit | Sayfa bilgilerinin düzenlendiği sayfa. Bu sayfayı oluşturulacak görünümlere `$page` değişkeni aktarılır. | GET |
| admin.page.update | Sayfa bilgilerinin düzenlendiği sayfadan form verilerinin gönderildiği sayfa | PUT-PATCH |
| admin.page.destroy | Sayfanın silindiği sayfa | DELETE |
| admin.page.publish | Sayfanın yayınlandığı rota | GET |
| admin.page.notPublish | Sayfanın yayından kaldırıldığı rota | GET |
| api.page.index | Bu rotada ajax ile Datatable türü veriler çekilir. Gelen sütunlar şunlardır: `id`, `category_id`, `slug`, `title`, `is_publish`, `created_at`, `category` (kategorinin adı, id'si vb), `urls` *(tablonun eylemler sütununda kullanılmak üzere oluşturulmuş bazı adreslerdir.)*. Bütün bunlar dışında `action=filter` verisi ile birlikte; *id*, *title*, *slug*, *category*, *status*, *created_at_from* ve *created_at_to* verileri gönderilerek; filtrelenmiş veriler elde edebilirsin | GET |
| api.page.store | Yeni sayfa eklenmesi için verilerin gönderildiği sayfa. | POST |
| api.page.update | Sayfa bilgilerinin düzenlenmesi için verilerin gönderildiği sayfa. | PUT-PATCH |
| api.page.destroy | Sayfanın silinmesi için verilerin gönderildiği sayfa | DELETE |
| api.page.group | Sayfaların üzerinde grup işlemleri yapmak için kullanılan bir rota. Yayınlama, yayından kaldırma ve silme işlemini destekliyor. `action=publish` gibi bir veri ile birlikte, dizi içinde işlem yapılacak kullanıcı id'leri gönderilir. Aşağıda veri detayları açıklanmıştır. | POST |
| api.page.detail | Sayfa id'si iliştirilmiş rota ile kullanıcı *id*, *category_id*, *title*, *slug*, *description*, *content*, *updated_at*, *created_at*  bilgileri Datatable formatında gönderilir | GET |
| api.page.fastEdit | Hızlı bir şekilde sayfa bilgisini düzenlemek için; bilgilerin çekildiği rotadır. Rotaya sayfa id'si iliştirilir ve sayfa bilgilerinin tamamı çekilir | POST |
| api.page.publish | Sayfanın yayınlandığı rota | POST |
| api.page.notPublish | Sayfanın yayından kaldırıldığı rota | POST |
| api.page.contentUpdate | Sayfanın içeriğinin güncellendği rota | POST |



<a name="kullanim-gorunumTasarlama-formAlanlari"></a>
##### Form Alanları
İşlemler sırasında görünümlerinde kullanacağın form elemanları veri tabanı tablolarındaki sütun isimleriyle aynı olmalıdır. Aşağıda her işlem için gereken eleman listesi verilmiştir.

:exclamation: Aşağıda belirtilen form isimleri kullanılması zorunlu olup, sırası değişebilir.

> `lang/.../validation.php` dosyanda bu form isimlerinin metin değerlerini belirtmeyi unutma! Ayrıca her dil için validation dosyası oluşturmalısın.

<a name="kullanim-gorunumTasarlama-formAlanlari-page_category"></a>
###### Sayfa Kategori Formları

* `store` işlemi form elemanları
    * name

**StoreRequest**

```php
public function rules()
{
    return [
      'name'          => 'required|max:255'
    ];
}
```

* `update` işlemi form elemanları
    * name

**UpdateRequest**

```php
public function rules()
{
    return [
      'name'          => 'required|max:255'
    ];
}
```

* Api `index` filtreleme işlemi verileri
    * action=filter
    * id
    * name
    * created_at_from
    * created_at_to

* Api `store` işlemi verileri, yukarıdaki *store* işlemi ile aynıdır.

* Api `update` işlemi verileri, yukarıdaki *update* işlemi ile aynıdır.

* Api `group` işlemi verileri
    * action=destroy
    * id (array şeklinde model id'leri)

<a name="kullanim-gorunumTasarlama-formAlanlari-category_pages"></a>
###### Kategoriye Ait Sayfa Formları

* `store` işlemi form elemanları
    * category_id (Belirli bir kategoriye ait sayfa olduğu için; görünüm içinde hidden elementte değer tutulur)
    * title
    * slug
    * description
    * is_publish
    * content
    * meta_title
    * meta_description
    * meta_keywords

**StoreRequest**

```php
public function rules()
{
    return [
      'category_id'       => 'required|integer',
      'title'             => 'required|max:255',
      'slug'              => 'alpha_dash|max:255|unique:pages',
      'description'       => 'max:255',
      'meta_title'        => 'max:255',
      'meta_description'  => 'max:255',
      'meta_keywords'     => 'max:255',
    ];
}
```

* `update` işlemi form elemanları
    * category_id (Belirli bir kategoriye ait sayfa olduğu için; görünüm içinde hidden elementte değer tutulur)
    * title
    * slug
    * description
    * is_publish
    * content
    * meta_title
    * meta_description
    * meta_keywords

**UpdateRequest**

```php
public function rules()
{
    $id = is_null($this->segment(5)) ? $this->segment(3) : $this->segment(5);
    return [
      'category_id'       => 'required|integer',
      'title'             => 'required|max:255',
      'slug'              => 'alpha_dash|max:255|unique:pages,slug,'.$id,
      'description'       => 'max:255',
      'meta_title'        => 'max:255',
      'meta_description'  => 'max:255',
      'meta_keywords'     => 'max:255',
    ];
}
```

* Api `index` filtreleme işlemi verileri
    * action=filter
    * id
    * slug
    * title
    * status
    * created_at_from
    * created_at_to

* Api `store` işlemi verileri, yukarıdaki *store* işlemi ile aynıdır.

* Api `update` işlemi verileri, yukarıdaki *update* işlemi ile aynıdır.

* Api `group` işlemi verileri
    * action=publish|not_publish|destroy
    * id (array şeklinde model id'leri)

<a name="kullanim-gorunumTasarlama-formAlanlari-page"></a>
###### Sayfa Formları
Bütün alanlar yukarıdaki [Kategoriye Ait Sayfa Formları](#kullanim-gorunumTasarlama-formAlanlari-category_pages) bölümüyle aynıdır. Farklı olan yer sadece Api `index` filtreleme işlemidir.

* Api `index` filtreleme işlemi verileri
    * action=filter
    * id
    * slug
    * title
    * `category`
    * status
    * created_at_from
    * created_at_to



<a name="kullanim-onaylamalar"></a>
### Onaylamalar
**Laravel Page Module** paketi yapılan her form isteği için onaylama kurallarını belirlemiştir. Bu tür form istek onaylama kuralları için yapman gereken bir şey yoktur. Yukarıda `Request` sınıflarının `rules` metotlarında açıklamaları yapılmıştır.


<a name="kullanim-olaylar"></a>
### Olaylar
Paket içindeki hemen hemen tüm işlemler belli bir olayı tetikler. Sen kendi listener dosyanda bu olayları dinleyebilir ve tetiklendiğinde istediğin işlemleri kolay bir şekilde yapabilirsin.
 

<a name="kullanim-olaylar-page_category"></a>
##### Sayfa Kategori Olayları

| Olay | İsim Uzayı | Olay Verisi | Açıklama |
|------|------------|-------------|----------|
| StoreSuccess | `ErenMustafaOzdal\LaravelPageModule\Events\PageCategory` | PageCategory Model | Ekleme işlemi başarılı olduğunda tetiklenir |
| StoreFail | `ErenMustafaOzdal\LaravelPageModule\Events\PageCategory` | Form verileri *(Array)* | Ekleme işlemi başarısız olduğunda tetiklenir |
| UpdateSuccess | `ErenMustafaOzdal\LaravelPageModule\Events\PageCategory` | PageCategory Model | Düzenleme işlemi başarılı olduğunda tetiklenir |
| UpdateFail | `ErenMustafaOzdal\LaravelPageModule\Events\PageCategory` | PageCategory Model | Düzenleme işlemi başarısız olduğunda tetiklenir |
| DestroySuccess | `ErenMustafaOzdal\LaravelPageModule\Events\PageCategory` | PageCategory Model | Silme işlemi başarılı olduğunda tetiklenir |
| DestroyFail | `ErenMustafaOzdal\LaravelPageModule\Events\PageCategory` | PageCategory Model | Silme işlemi başarısız olduğunda tetiklenir |
 

<a name="kullanim-olaylar-page"></a>
##### Sayfa Olayları

| Olay | İsim Uzayı | Olay Verisi | Açıklama |
|------|------------|-------------|----------|
| StoreSuccess | `ErenMustafaOzdal\LaravelPageModule\Events\Page` | Page Model | Ekleme işlemi başarılı olduğunda tetiklenir |
| StoreFail | `ErenMustafaOzdal\LaravelPageModule\Events\Page` | Form verileri *(Array)* | Ekleme işlemi başarısız olduğunda tetiklenir |
| UpdateSuccess | `ErenMustafaOzdal\LaravelPageModule\Events\Page` | Page Model | Düzenleme işlemi başarılı olduğunda tetiklenir |
| UpdateFail | `ErenMustafaOzdal\LaravelPageModule\Events\Page` | Page Model | Düzenleme işlemi başarısız olduğunda tetiklenir |
| DestroySuccess | `ErenMustafaOzdal\LaravelPageModule\Events\Page` | Page Model | Silme işlemi başarılı olduğunda tetiklenir |
| DestroyFail | `ErenMustafaOzdal\LaravelPageModule\Events\Page` | Page Model | Silme işlemi başarısız olduğunda tetiklenir |
| PublishSuccess | `ErenMustafaOzdal\LaravelPageModule\Events\Page` | Page Model | Yayınlama işlemi başarılı olduğunda tetiklenir |
| PublishFail | `ErenMustafaOzdal\LaravelPageModule\Events\Page` | Page Model | Yayınlama işlemi başarısız olduğunda tetiklenir |
| NotPublishSuccess | `ErenMustafaOzdal\LaravelPageModule\Events\Page` | Page Model | Yayından kaldırma işlemi başarılı olduğunda tetiklenir |
| NotPublishFail | `ErenMustafaOzdal\LaravelPageModule\Events\Page` | Page Model | Yayından kaldırma işlemi başarısız olduğunda tetiklenir |
 
 
<a name="lisans"></a>
Lisans
------
MIT
