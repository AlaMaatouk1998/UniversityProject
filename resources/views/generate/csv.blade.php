<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des etablissements</title>
<style>
    table td{
        width: 250px;
    }
</style>
</head>

<body>
<div >
        <table >
            <thead>
            <tr>
                <th style="text-align: center; font-weight: 600">Université</th>
                <th style="text-align: center; font-weight: 600">Etablissement</th>
                <th style="text-align: center; font-weight: 600">Diplome</th>
                <th style="text-align: center; font-weight: 600">Spécialités</th>
                <th style="text-align: center; font-weight: 600">Mention</th>
                <th style="text-align: center; font-weight: 600">Durée d'habilitation</th>
            </tr>
            </thead>
            <tbody >

            <!-- <tr v-if="universites.length == 0">
                <td colspan="7">
                    <div class="login text-center">
                        Aucune donnée disponible...
                    </div>
                </td>
            </tr> -->
                @foreach($universites as $universite)
                        @foreach($universite['etablissements'] as $etablissement)
                          @foreach($etablissement['specialites'] as $specialite)
                            <tr style="border-top: 1px solid black;">
                                <td style="width: 20px; height:30px; vertical-align: center;">{{$universite['titre']}}</td>
                                <td style="width: 20px; height:30px; vertical-align: center;"> {{ $etablissement['titre'] }}</td>
                                <td style="width: 20px; height:30px; vertical-align: center;" >{{$specialite['diplome']['titre']}}</td>
                                <td style="width: 50px; height:30px; vertical-align: center;" >{{$specialite['titre']}}</td>
                                <td style="width: 30px; height:30px; vertical-align: center;" >{{$specialite['mention']['titre']}}</td>
                                <td style="width: 30px; height:30px; vertical-align: center;" >{{$specialite['titre']}}</td>
                            </tr>     
                          @endforeach      
                        @endforeach
                @endforeach
            </tbody>
        </table>
        </div>
</body>
</html>