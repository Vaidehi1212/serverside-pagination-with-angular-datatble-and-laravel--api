class ViewPlaceFormController{
    constructor($stateParams,AclService,API){
        'ngInject';
    this.alerts = []
    this.can = AclService.can
        
        if ($stateParams.alerts) {
      this.alerts.push($stateParams.alerts)
    }

    let blogId = $stateParams.placeId
    let blog = API.service('place-edit')
    blog.one(blogId).get()
    .then((response) => {
      this.maincourse = API.copy(response)

    })
    }

    $onInit(){
    }
}

export const ViewPlaceFormComponent = {
    templateUrl: './views/app/components/admin/courseplace/view_place_form/view_place_form.component.html',
    controller: ViewPlaceFormController,
    controllerAs: 'vm',
    bindings: {}
};
