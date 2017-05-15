<!DOCTYPE html>
<html lang="en" ng-app="Cannes">
<head>
    <meta charset="UTF-8">
    <title>Cannes Tickets</title>
    <script src="/bower_components/angular/angular.js"></script>
    <script src="/bower_components/angular-foundation-6/dist/angular-foundation.min.js"></script>
    <script src="/bower_components/angular-touch/angular-touch.min.js"></script>
    <script src="/bower_components/angular-route/angular-route.min.js"></script>
    <script src="/app.js"></script>

    <link rel="stylesheet" href="/bower_components/foundation-sites/dist/css/foundation-flex.min.css" />
    <link rel="stylesheet" href="/app.css" />
</head>
<body>

<div class="container">
    <table ng-controller="FrontController as ctrl">
        <tr class="salles">
            <th>
                &nbsp;
            </th>
            <th>
                Debussy
            </th>
            <th colspan="7">
                Lumière
            </th>
        </tr>
        <tr ng-repeat="jour in ctrl.seances.dates" class="seances">
            <th>
                {{ctrl.dates[jour.jour]}}
            </th>
            <td ng-repeat="seance in jour.seances" ng-class="seance.film < 0 ? 'none' : (seance.book == 0 ? 'available' : (seance.book > 0 ? 'booked' : 'already_booked'))">
                <div ng-hide="seance.film < 0" class="seance">
                    <p><strong>{{ctrl.films[seance.film].titre}}</strong></p>
                    <p>{{ctrl.films[seance.film].realisateur}}</p>
                    <div>
                        <span class="heure">{{seance.heure}}</span>
                        <div ng-switch on="seance.book" ng-if="seance.film >= 0" class="status">
                      <span class="question" ng-switch-default>
                        <button ng-click="ctrl.booked(seance.id, jour.jour)">Demander</button>
                      </span>
                            <span class="attente" ng-switch-when="1">
                        <button ng-click="ctrl.cancel(seance.id, jour.jour)">Demandée</button>
                      </span>
                            <span class="question" ng-switch-when="-1">
                        Film demandée
                      </span>
                        </div>
                    </div>
                    <p ng-if="seance.demande == 'High'" class="red-circle">
                        <span></span>
                    </p>
                </div>
            </td>
        </tr>
    </table>
    <p>{{ctrl.msg}}</p>
</div>

</body>
</html>