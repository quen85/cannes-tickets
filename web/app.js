var app = angular.module("Cannes", ["ngTouch", "mm.foundation"]);

app.controller('FrontController',
    ['$scope', '$http', '$filter',
        function($scope, $http, $filter){
            var ctrl = this;
            ctrl.films = null;
            ctrl.seances = null;
            ctrl.dates = ['dimanche 14', 'lundi 15', 'mardi 16', 'mercredi 17', 'jeudi 18', 'vendredi 19', 'samedi 20'];
            ctrl.credit = 7;
            ctrl.msg = '';

            // var data = $.param({
            //     firstName: $scope.firstName
            // });

            var promListing = $http.get("data/dates.json");
            promListing.then(function(response){
                ctrl.seances = response.data;
            });
            var promListingFilms = $http.get("data/films.json");
            promListingFilms.then(function(response){
                ctrl.films = response.data.films;
            });

            ctrl.booked = function(id, date){
                var seances = ctrl.seances.dates[date].seances;
                var n_seance = id%8;
                var booked_film = seances[n_seance].film;

                if(ctrl.credit > 0){
                    if(creditCheck(seances)){
                        var list_films = findByIdFilm(seances, booked_film);
                        if(seances[n_seance].demande == "High"){
                            if(ctrl.credit > 1){
                                bookById(id, seances, list_films);
                                ctrl.credit = ctrl.credit - 2;
                            }else{
                                window.alert("Vous n'avez pas assez de crédit pour cette séance.");
                            }
                        }else{
                            bookById(id, seances, list_films);
                            ctrl.credit--;
                        }
                    }else{
                        window.alert("Vous avez déjà utilisé votre crédit pour ce jour. Il vous reste " + ctrl.credit + " crédit à utiliser sur les autres jours. Vous avez le droit à un credit par jour.");
                    }
                }else{
                    window.alert("Vous avez utilisé tout votre crédit pour ce festival. Pour pouvoir réserver cette séance, veuillez annuler l'autre réservation du même jour.")
                }
            }

            ctrl.cancel = function(id, date){
                var seances = ctrl.seances.dates[date].seances;
                var n_seance = id%8;
                var booked_film = seances[n_seance].film;

                var confirmation = window.confirm("Etes-vous sûr de vouloir annuler cette réservation ?");

                if(confirmation){
                    var list_films = findByIdFilm(seances, booked_film);
                    cancelById(seances, list_films);
                }
                if(seances[n_seance].demande == "High"){
                    ctrl.credit = ctrl.credit + 2;
                }else{
                    ctrl.credit++;
                }
            }


            function findByIdFilm(data, idToLookFor) {
                var list_seances = [];

                for (var i = 0; i < data['length']; i++) {
                    if (data[i]['film'] == idToLookFor) {
                        list_seances.push(data[i]['id']);
                    }
                }

                return list_seances;
            }

            function bookById(id, data, array) {
                for (var i = 0; i < data['length']; i++) {
                    if(data[i]['id'] == id){
                        data[i]['book'] = 1;
                    }
                    else if (array.includes(data[i]['id'])) {
                        data[i]['book'] = -1;
                    }
                }
            }

            function cancelById(data, array) {
                for (var i = 0; i < data['length']; i++) {
                    if (array.includes(data[i]['id'])) {
                        data[i]['book'] = 0;
                    }
                }
            }

            function creditCheck(data) {
                for (var i = 0; i < data['length']; i++) {
                    if (data[i]['book'] == 0) {
                        continue;
                    }else{
                        return false;
                    }
                }
                return true;
            }
        }]);