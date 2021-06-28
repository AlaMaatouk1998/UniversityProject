<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des etablissements</title>
<style>
body{
    font-family: 'Calibri', 'Arial';
}
table{
    border-collapse: collapse;
}
.titleTable{
     text-align: center;
    vertical-align: middle;
    background: #dfe6e9;
    padding: 0px;
    
}
.titleTable h4{
    padding-top: 20px;
}
table td, table th{
    padding-left: 5px;
    border-top: 0.0625rem solid black; 
}
table th{
    text-align: left;
}
.border-right{
    border-right: 0.0625rem solid black;
}
table td{
    padding-left: 5px;
    border-right: 0.5px solid black;
}
</style>
</head>

<body>
    {!! $filtres !!}
<div style="border:1px solid black">
        <table>
            <thead>
            <tr>
                <th>Etablissements</th>
                <th>Diplome</th>
                <th>Spécialités</th>
                <th>Mention</th>
                <th class="border-right">Durée d'habilitation</th>
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
                    <td colspan="6" class="titleTable"> <h3>{{$universite['titre']}}</h3></td>
                </tr>
                  
                        @foreach($universite['etablissements'] as $etablissement)
                            @php($nb = 1)
                          @foreach($etablissement['specialites'] as $specialite)
                            <tr style="border-top: 1px solid black;">
                                @if($nb == 1)
                                 <td class="border-right" rowspan="{{count($etablissement['specialites'])}}">{{ $etablissement['titre'] }}</td>
                                @endif
                                <td >{{$specialite['diplome']['titre']}}</td>
                                <td >{{$specialite['titre']}}</td>
                                <td >{{$specialite['mention']['titre']}}</td>
                                <td class="border-right">{{$specialite['titre']}}</td>
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