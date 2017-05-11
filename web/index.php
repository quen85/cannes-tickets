<!DOCTYPE html>
<html lang="en" ng-app="Cannes">
<head>
    <meta charset="UTF-8">
    <title>Cannes Tickets</title>
    <script src="/bower_components/angular/angular.js"></script>
    <script src="/bower_components/angular-foundation-6/dist/angular-foundation.min.js"></script>
    <script src="/bower_components/angular-touch/angular-touch.min.js"></script>
    <script src="/bower_components/angular-route/angular-route.min.js"></script>
    <script src="app.js"></script>

    <link rel="stylesheet" href="/bower_components/foundation-sites/dist/css/foundation-flex.min.css" />
    <link rel="stylesheet" href="app.css" />
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
            <td ng-repeat="seance in jour.seances" ng-class="{none: seance.film < 0, available: seance.book == 0}">
              <div ng-hide="seance.film < 0">
                <p><strong>{{ctrl.films[seance.film].titre}}</strong></p>
                <p>{{ctrl.films[seance.film].realisateur}}</p>
                <p>
                    <span class="heure">{{seance.heure}}</span>
                    <span class="question" ng-if="seance.book == 0 && seance.film >= 0"><button ng-click="ctrl.booked(seance.film, jour.jour)">Demander</button></span>
                    <span class="attente" ng-if="seance.book == 1 && seance.film >= 0"><a>Demandée</a></span>
                </p>
                <p ng-if="seance.demande == 'High'">
                    <span class="red-circle"></span>
                </p>
              </div>
            </td>
        </tr>
    </table>
    <p>{{ctrl.msg}}</p>
</div>

</body>
</html>