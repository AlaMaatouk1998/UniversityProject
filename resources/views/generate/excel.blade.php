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
                <th style="text-align: center; font-weight: 600">Etablissements</th>
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
           
                <tr >
                    <td colspan="6" style="background: #b2bec3; text-align: center; font-weight: 600; height: 20px; border: 1px solid black;"> <h3>{{$universite['titre']}}</h3></td>
                </tr>
                  
                        @foreach($universite['etablissements'] as $etablissement)
                            @php($nb = 1)
                          @foreach($etablissement['specialites'] as $specialite)
                            <tr style="border-top: 1px solid black;">
                                @if($nb == 1)
                                 <td style="vertical-align: center; width: 50px" rowspan="{{count($etablissement['specialites'])}}">{{ $etablissement['titre'] }}</td>
                                @endif
                                <td style="width: 20px; height:30px; vertical-align: center;" >{{$specialite['diplome']['titre']}}</td>
                                <td style="width: 50px; height:30px; vertical-align: center;" >{{$specialite['titre']}}</td>
                                <td style="width: 30px; height:30px; vertical-align: center;" >{{$specialite['mention']['titre']}}</td>
                                <td style="width: 30px; height:30px; vertical-align: center;" >{{$specialite['titre']}}</td>
                            </tr>     
                                @php($nb++)
                          @endforeach      
                        @endforeach
            
                @endforeach
            </tbody>
        </table>
        </div>
</body>
</html>