# Si Jawara
[![MCFLYON TEKNOLOGI INDONESIA](/public/assets/media/mcflyon.png)](https://www.mcflyon.co.id/)

### Specification

- `Laravel 5.5`
- `VueJS 2.6`
- `Metronic 7`

### Installation

Installation is simple. It can be install using the following command:
```sh
$ git clone https://gitlab.com/luciferozi/si-jawara.git
$ cd si-jawara
$ composer install
$ npm install
```

Let's Build Own Web System Application.

### Feature

Some Feature Include In Base Framework

- **Auto Push Git by Mcflyon**

	Auto Push Git with Artisan Command

	```sh
	$php artisan mti:push
	```

	Will push to git repository, please reset git by deleting .git folder `rm -rf .git` and init again with new repository.

- **Auto Generate VueJS File by Mcflyon**
	
	Auto Generate VueJS File with Artisan Command

	```sh
	$php artisan make:vue <dir/path/to/file>
	```

	Example:

	```sh
	$php artisan make:vue user/home/Index
	```

	Will create new VueJS file in `resources/assets/js/pages/user/home/Index.vue`

- **MTI PAGINATE**

	Auto Pagination with VueJS

	```html
	<mti-paginate id="myTable" ref="myTable" classx="table table-striped table-bordered text-center" :columns="columns" url="/test" :post="postData" :callback="callback"></mti-paginate>
	```
	- ADD classx attributes when give Custom Class
	- ADD callback attributes when give Custom Callback (Remove When Not Use)
	- ADD post attributes when give Custom Post Field (Remove When Not Use)

	```javascript
	export default {
		data() {
			return {
				columns: [
					{name: 'Name', data: 'name'},
					{name: 'Email', data: 'email'},
					{name: 'Aksi', data: 'action'}
				],
				// Post Example
				postData: {tahun: 2020}
			}
		},
		methods: {
			loadJs(){
			},
            callback(){
            	// Callback Example
            	var vm = this;
            	$('#myTable').on('click', '.btn-detail', function(e){
            		var id = $(this).data('id');
            		// FOR RELOAD TABLE
            		vm.$refs.myTable.reload();
            	});
            }
		},
		mounted() {
			this.loadJs()
			this.$parent.middleware('admin');
		}
	}
	```

	Examples :
		- Controller : app/Http/Controllers/AuthController@testing
		- View : resources/assets/js/pages/admin/home/Index

- **Find With UUID**

	*Use : `NamaModel::findByUuid($uuid)`*

- **Format Rupiah**

	For Format Number/String : 1000000

	*Use : number.rupiah()*

	```javascript
	var uang = 1000000;
	console.log(uang.rupiah())
	// 1.000.000
	```

- **Tanggal Indonesia With Time (Timestamp)**

	For Format Timestamp : 2020-01-21 15:30:00

	*Use : string.tgl_indo()*
	
	args `true|false` : with time.

	```javascript
	var created_at = "2020-01-21 15:30:00";
	console.log(created_at.tgl_indo())
	// 21 Januari 2019
	OR
	console.log(created_at.tgl_indo(true))
	// 21 Januari 2019 15:30:00
	```


- **Tanggal Indonesia Only (Date)**

	For Format Date : 2020-01-21

	*Use : string.indo()*

	```javascript
	var created_at = "2020-01-21";
	console.log(created_at.indo())
	// 21 Januari 2019
	```