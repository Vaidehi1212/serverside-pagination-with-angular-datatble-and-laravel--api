class CreatePlaceFormController{
   constructor (API, $state, $stateParams,AclService,$timeout) {
        'ngInject'

        this.$state = $state
        this.formSubmitted = false
        this.API = API
        this.$timeout = $timeout
        this.can = AclService.can
        this.alerts = []

        if ($stateParams.alerts) {
            this.alerts.push($stateParams.alerts)
        }
       
    }

    save (isValid) {
        this.$state.go(this.$state.current, {}, { alerts: 'test' })
        console.log(this);
        if (isValid) {
            let Blog = this.API.all('place')
            let $state = this.$state
            let $timeout = this.$timeout
            Blog.post({
                'Name': this.Name,
                'Comments': this.Comments,
                'Type': this.Type,
                'IsActive': this.IsActive,
            }).then(function () {
                let alert = { type: 'success', 'title': 'Success!', msg: 'Place has been added.' }
                $state.go($state.current, { alerts: alert})
    
                $timeout(function() {
                   $state.go('app.userlist.list_place')
                }, 3000);
                
            }, function (response) {
                let alert = { type: 'error', 'title': 'Error!', msg: response.data.errors }
                $state.go($state.current, { alerts: alert})
              })  
        } else {
            this.formSubmitted = true
        }
    }

    $onInit () {}
}

export const CreatePlaceFormComponent = {
    templateUrl: './views/app/components/admin/courseplace/create_place_form/create_place_form.component.html',
    controller: CreatePlaceFormController,
    controllerAs: 'vm',
    bindings: {}
}
