class EditPlaceFormController{
    constructor ($stateParams, $state, API, AclService, $timeout) {
    'ngInject'

    this.$state = $state
    this.formSubmitted = false
    this.$timeout = $timeout
    this.can = AclService.can
    this.alerts = []

    if ($stateParams.alerts) {
      this.alerts.push($stateParams.alerts)
    }

    let blogId = $stateParams.placeId
    let blog = API.service('place-edit')
    blog.one(blogId).get()
      .then((response) => {
        this.blog = API.copy(response)
      })
  }

  save (isValid) {
    if (isValid) {
      let $state = this.$state
      let $timeout = this.$timeout

      this.blog.put()
        .then(() => {
          let alert = { type: 'success', 'title': 'Success!', msg: 'Place has been updated.' }
          $state.go($state.current, { alerts: alert})

            $timeout(function() {
               $state.go('app.userlist.list_place')
            }, 3000);

        }, (response) => {
          let alert = { type: 'error', 'title': 'Error!', msg: response.data.errors }
          $state.go($state.current, { alerts: alert})
        })
    } else {
      this.formSubmitted = true
    }
  }

  $onInit () {}
}

export const EditPlaceFormComponent = {
    templateUrl: './views/app/components/admin/courseplace/edit_place_form/edit_place_form.component.html',
    controller: EditPlaceFormController,
    controllerAs: 'vm',
    bindings: {}
}
