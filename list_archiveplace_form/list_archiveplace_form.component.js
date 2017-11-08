class ListArchiveplaceFormController{
  constructor ($scope, $state, $compile, DTOptionsBuilder, DTColumnBuilder, API,AclService, $filter)  {
    'ngInject'
    this.API = API
    this.$state = $state
    this.can = AclService.can
    this.$filter = $filter

    var obj = { store: localStorage };  
    var lang=obj.store.getItem('lang'); 
    let Websites = this.API.service('deletedplace')

    Websites.getList()
    .then((response) => {
      let dataSet = response.plain()

      this.dtOptions = DTOptionsBuilder.newOptions()
      .withOption('data', dataSet)
      .withOption('createdRow', createdRow)
      .withOption('responsive', true)
      .withOption('language',{
      'url': "/translations/" +lang +".json"
       })
      .withBootstrap()
      this.dtColumns = [
      DTColumnBuilder.newColumn('Id').withTitle(this.$filter('translate')('Id')),
      DTColumnBuilder.newColumn('Name').withTitle(this.$filter('translate')('Name')),
      DTColumnBuilder.newColumn('Comments').withTitle(this.$filter('translate')('Comments')),
      DTColumnBuilder.newColumn('Type').withTitle(this.$filter('translate')('Type')),
      DTColumnBuilder.newColumn('IsActive').withTitle(this.$filter('translate')('IsActive')).notSortable().renderWith(statusHtml),
      DTColumnBuilder.newColumn(null).withTitle(this.$filter('translate')('Actions')).notSortable()
      .renderWith(actionsHtml)
      ]

      this.displayTable = true
    })

    let createdRow = (row) => {
      $compile(angular.element(row).contents())($scope)
    }

    let statusHtml=(IsActive)=>{
      if(IsActive == 1){
       return ` <a class="btn btn-xs btn-success">
       <i>{{"Active"|translate}}</i>
       </a>`
     }else
     {
       return ` <a class="btn btn-xs btn-danger">
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
    <a ng-show="vm.can('update.place')" class="btn btn-xs btn-warning" ng-click="vm.recover(${data.Id})" tooltips tooltip-template={{"Recover"|translate}}> 
    <i class="fa fa-undo" aria-hidden="true"></i>
    </a>
    &nbsp
    <button ng-show="vm.can('delete.place')" class="btn btn-xs btn-danger" ng-click="vm.delete(${data.Id})" tooltips tooltip-template={{"Delete"|translate}}>
        <i class="fa fa-trash-o"></i>
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
                text: t('You will not be able to recover this data!'),
                type: 'warning',
                showCancelButton: true,
                cancelButtonText:t('Cancel'),
                confirmButtonColor: '#DD6B55',
                confirmButtonText: t('Yes, delete it!'),
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                html: false
              }, function () {
                API.one('place').one('harddelete', placeId).remove()
                .then((response) => {
                    if (response.data != 'error') {
                    swal({
                      title: t('Deleted!'),
                      text: t('Place has been deleted.'),
                      type: 'success',
                      confirmButtonText: t('OK'),
                      closeOnConfirm: true
                  }, function () {
                      $state.reload()
                  })
                  }else{
                    swal({
                      title: t('Error!'),
                      text: t('Only admin can delete place.'),
                      type: 'error',
                      confirmButtonText: t('OK'),
                      closeOnConfirm: true
                  })
                  }
               })
              })
            }

            recover (placeId) {
              let API = this.API
              let $state = this.$state
              let $filter=this.$filter
              let t=$filter('translate')

              swal({
                title: t('Are you sure?'),
                text: t('You Want to recover this data!'),
                type: 'warning',
                showCancelButton: true,
                cancelButtonText:t('Cancel'),
                confirmButtonColor: '#DD6B55',
                confirmButtonText: t('Yes, Recover it!'),
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                html: false
              }, function () {
                API.one('recoverplace', placeId).get()
                .then(() => {
                  swal({
                    title: t('Recovered!'),
                    text: t('Place has been Recovered.'),
                    type: 'success',
                    confirmButtonText: t('OK'),
                    closeOnConfirm: true
                  }, function () {
                    $state.reload()
                  })
                })
              })
            }

            $onInit(){
            }
          }

          export const ListArchiveplaceFormComponent = {
            templateUrl: './views/app/components/admin/courseplace/list_archiveplace_form/list_archiveplace_form.component.html',
            controller: ListArchiveplaceFormController,
            controllerAs: 'vm',
            bindings: {}
          };
