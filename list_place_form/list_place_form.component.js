class ListPlaceFormController{
  constructor ($scope, $state, $compile, DTOptionsBuilder, $filter, DTColumnBuilder, API,AclService,$localStorage,$http,PlaceDataService) {
    'ngInject'
    this.API = API
    this.$state = $state
    this.can = AclService.can
    this.$filter = $filter
    this.$http = $http


    $scope.items = [];
    $scope.lastpage=1;
    var obj = { store: localStorage };
    var lang=obj.store.getItem('lang');
    let Websites = this.API.service('places')


  var vm = this;
  vm.selected = {};
  vm.selectAll = false;
  vm.toggleAll = toggleAll;
  vm.toggleOne = toggleOne;

  var titleHtml = '<input type="checkbox" ng-model="vm.selectAll" ng-click="vm.toggleAll(vm.selectAll,vm.selected)">';

  this.dtOptions = DTOptionsBuilder
  .newOptions()
  // .withDataProp('data', $scope.dataSet)


  // .withPaginationType('full_numbers')
  // .withOption('headerCallback',createHeader)
  // .withOption('language',{
  //   'url': "/translations/" +lang +".json"
  // })
  // .withOption('ajax',function(){
  //       // url:  $scope.dataSet,
  //       url:   'api/places',
  //       type: 'GET',
  //       data: function(d, settings){
  //          var api = new $.fn.dataTable.Api(settings);

  //          // Update URL
  //          api.ajax.url(
  //             'api/places/products/filter?pageNo=' + d.start + '&pageSize=' + d.length
  //          );

  //          // Store "draw" parameter
  //          vm.dtDraw = d.draw;

  //          return JSON.stringify(d);
  //      }
  //     })


  // // .fromFnPromise(function() {
  // //       // return Restangular.all('data').getList();
  // //       Websites.getList()
  // //       return Websites.getList().then((response) => { return response.plain() });
  // //     })
  // // .withDataProp('data')
  .withOption('ajax', {
   url: 'api/places',
   type: 'GET',

        //  error: function(response){
        //   console.log("inside error response",response)
        // },
        // success: function(data, status, headers, config){
        //   console.log("inside success: ", data, status, headers, config)
        //   // return data;
        //   // $scope.data=data
        // }
      })
     // or here

     // .withDataProp('data')
   //  .withDataProp('data',ssfunction(data){
   //     console.log(" ajax > post > success > response > ", data);

   //     // Retrieve "draw" parameter
   //     // json.draw = vm.dtDraw;

   //     // json.recordsTotal = json.list.length;
   //     // json.recordsFiltered = json.list.length;

   //     // return json.list;
   // })
   .withOption('processing', true)
   .withOption('serverSide', true)
     // .withPaginationType('full_numbers');
     .withOption('createdRow', createdRow)
     // .withOption('order', [[0, 'asc'], [1, 'asc']])
     .withOption('responsive', true)
     .withDisplayLength(10)
     .withPaginationType('simple_numbers')
     .withBootstrap()

  // .withOption('serverSide', true)
  // .withOption('processing', true)
  // .withDisplayLength(10)

  // .withOption('order', [[0, 'asc'], [1, 'asc']])

  this.dtColumns = [

  // DTColumnBuilder.newColumn('id').withTitle('Id'),
  // DTColumnBuilder.newColumn('firstName').withTitle('firstName'),
  // DTColumnBuilder.newColumn('lastName').withTitle('lastName'),


  DTColumnBuilder.newColumn('Name').withTitle(this.$filter('translate')('Place_public_name')),
  DTColumnBuilder.newColumn('Comments').withTitle(this.$filter('translate')('Classroom_name')),
  DTColumnBuilder.newColumn('Type').withTitle(this.$filter('translate')('Place_ShortName')),
  DTColumnBuilder.newColumn('IsActive').withTitle(this.$filter('translate')('Status')),
  ]




    // this.dtColumns = [
    // DTColumnBuilder.newColumn(null).withTitle(titleHtml).notSortable()
    // .renderWith(function(data, type, full, meta) {
    //   vm.selected[full.Id] = false;
    //   return '<input type="checkbox" ng-model="vm.selected[' + data.Id + ']" ng-click="vm.toggleOne(vm.selected)">';
    // }),
    // DTColumnBuilder.newColumn('Id').withTitle('Id'),
    // DTColumnBuilder.newColumn('Name').withTitle(this.$filter('translate')('Place_public_name')),
    // DTColumnBuilder.newColumn('Comments').withTitle(this.$filter('translate')('Classroom_name')),
    // DTColumnBuilder.newColumn('Type').withTitle(this.$filter('translate')('Place_ShortName')),
    // DTColumnBuilder.newColumn('IsActive').withTitle(this.$filter('translate')('Status')).notSortable().renderWith(statusHtml),
    // DTColumnBuilder.newColumn(null).withTitle(this.$filter('translate')('Actions')).notSortable()
    // .renderWith(actionsHtml)
    // ]

    function toggleAll (selectAll,selectedItems) {
      for (var Id in selectedItems) {
        if (selectedItems.hasOwnProperty(Id)) {
          selectedItems[Id] = selectAll;
        }
      }
    }

    function toggleOne (selectedItems) {
      for (var Id in selectedItems) {
        if (selectedItems.hasOwnProperty(Id)) {
          if(!selectedItems[Id]) {
            vm.selectAll = false;
            return;
          }
        }
      }
      vm.selectAll = true;
    }

    this.displayTable = true
  // })

  let createdRow = (row) => {
    $compile(angular.element(row).contents())($scope)
  }

  let createHeader = (header)=>{
    if (!this.headerCompiled) {
      this.headerCompiled = true;
      $compile(angular.element(header).contents())($scope);
    }
  }

  let statusHtml=(IsActive)=>{
    if(IsActive == 1){
     return ` <a class="btn btn-xs btn-success" style="pointer-events: none;">
     <i>{{"Active"|translate}}</i>
     </a>`
   }else
   {
     return ` <a class="btn btn-xs btn-danger" style="pointer-events: none;">
     <i>{{"Deactive"|translate}}</i>
     </a>`
   }
   
 }
 let actionsHtml = (data) => {
  return `
  <a ng-show="vm.can('manage.place')" class="btn btn-xs btn-primary" ui-sref="app.userlist.list_place.placeview({placeId: ${data.Id}})" tooltips tooltip-template={{"View"|translate}}>
  <i class="fa fa-eye"></i>
  </a>
  &nbsp
  <a ng-show="vm.can('update.place')" class="btn btn-xs btn-warning" ui-sref="app.userlist.list_place.placeedit({placeId: ${data.Id}})" tooltips tooltip-template={{"Edit"|translate}}>
  <i class="fa fa-edit"></i>
  </a>
  &nbsp
  <button ng-show="vm.can('delete.place')" class="btn btn-xs btn-danger" ng-click="vm.delete(${data.Id})" tooltips tooltip-template={{"Archive"|translate}}>
  <i class="fa fa-archive"></i>
  </button>`
}
}

delete (placeId) {
  let API = this.API
  let $state = this.$state
  let $filter=this.$filter
  let t=$filter('translate')

  swal({
    title: t('Are you sure?'),
    text: t('You will  be able to recover this data!'),
    type: 'warning',
    showCancelButton: true,
    cancelButtonText:t('Cancel'),
    confirmButtonColor: '#DD6B55',
    confirmButtonText: t('Yes, Archive it!'),
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
    html: false
  }, function () {
    API.one('place').one('delete', placeId).remove()
    .then(function () {
      swal({
        title: t('Deleted!'),
        text: t('Place has been moved to archive directory.'),
        type: 'success',
        confirmButtonText: t('OK'),
        closeOnConfirm: true
      }, function () {
        $state.reload()
      })
      
    }, function (response) {
      swal({
        title: t('Error!'),
        text: response.data.errors.message,
        type: 'error',
        confirmButtonText: t('OK'),
        closeOnConfirm: true
      }, function () {
        $state.reload()
      })
    })
  })
}

deletes () {
  let API = this.API
  let $state = this.$state
  var vm=this
  var obj = vm.selected
  var keys = Object.keys(obj)
  let $filter=this.$filter
  let t=$filter('translate')

  var filtered = keys.filter(function(key) {
    return obj[key]
  });
  if(filtered.length==0){
    swal({
      title: t('Select Data!'),
      text: t('Please select Data to Archive.'),
      type: 'warning',
      confirmButtonText: t('OK'),
      closeOnConfirm: true
    })
    return
  }
  swal({
    title:t('Are you sure?'),
    text: t('You will be able to recover this data From Archive!'),
    type: 'warning',
    showCancelButton: true,
    cancelButtonText: t('Cancel'),
    confirmButtonColor: '#DD6B55',
    confirmButtonText: t('Yes, Archive it!'),
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
    html: false
  }, function () {


    let Blog = API.all('place/deletes')
    Blog.post({
      'data': filtered,   
    })
    .then(() => {
      swal({
        title: t('Archived!'),
        text: t('Places has been Archived.'),
        type: 'success',
        confirmButtonText: t('OK'),
        closeOnConfirm: true
      }, function () {
       $state.reload()
     })
    })
  })
}

$onInit () {
  // let this.$scope=$scope
  // let this.$http=$http

  // $scope.lastpage=1;
  // $http({
  //   url: '/api/items',
  //   method: "GET",
  //   params: {page:  $scope.lastpage}
  // }).success(function(data, status, headers, config) {
  //   $scope.items = data.data;
  //   $scope.currentpage = data.current_page;
  // });
}
}

export const ListPlaceFormComponent = {
  templateUrl: './views/app/components/admin/courseplace/list_place_form/list_place_form.component.html',
  controller: ListPlaceFormController,
  controllerAs: 'vm',
  bindings: {}
}
