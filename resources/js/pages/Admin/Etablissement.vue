<template>
	<div class="content">
		<card>
			<template slot="header">
				<h5 class="title">Gérer les établissements</h5>
				<div class="row filtre">
					<div class="col-lg-4">
						<base-input label="Filtrer par université">
							<select
								class="form-control "
								@change="onFiltreUniversiteChange($event)"
                                v-model="filtres.universite"
							>
                                <option value="" disabled selected>Rechercher par universite</option>
								<option
									v-for="(universite, index) in universites"
									:value="universite.id"
									:key="index"
									>{{ universite.titre }}</option
								>
							</select>
						</base-input>
					</div>
					<div class="col-lg-4">
						<base-input label="Filtrer par gouvernorat">
							<select
								class="form-control "
								@change="onFiltreGouvernoratChange($event)"
                                v-model="filtres.gouvernorat"
							>
                                <option value="" disabled selected>Rechercher par gouvernorat</option>
								<option
									v-for="(gouvernorat, index) in gouvernorats"
									:value="gouvernorat.fr"
									:key="index"
									>{{ gouvernorat.fr }}</option
								>
							</select>
						</base-input>
					</div>
					<div class="col-lg-2">
						<base-button
							style="    margin-top: 23px;"
							type="warning"
							fill
							v-on:click="onFiltreAll()"
							>Voir tous</base-button
						>
					</div>
					<div
						class="col-lg-4"
						v-if="parseInt(user.role) == 3"
					>
						<base-button
							style="   margin-top: 23px;"
							type="success"
							fill
							v-on:click="initEtablissementModal()"
							>Ajouter une nouvelle etablissement</base-button
						>
					</div>
				</div>
			</template>
			<div class="table-responsive">
				<table class="table tablesorter text-left">
					<thead class="text-primary">
						<tr>
							<slot nom="columns">
                                <th>Université </th>
								<th>Titre (fr) </th>
								<th>Titre (ar)</th>
								<th>Type</th>
                                <th>Détails</th>
								<th>Spécialités</th>
								<th>&nbsp;</th>
							</slot>
						</tr>
					</thead>
					<tbody>
						<tr v-if="loading">
							<td colspan="7">
								<div class="login text-center">
									<i class="tim-icons  icon-refresh-02 rotating"></i>
								</div>
							</td>
						</tr>
						<tr v-if="etablissements.length == 0">
							<td colspan="7">
								<div class="login text-center">
									Aucune donnée trouvée...
								</div>
							</td>
						</tr>
						<tr v-for="(etablissement, index) in etablissements" :key="index">
                            <td>{{ etablissement.universite ? etablissement.universite.titre : '' }}</td>
							<td>{{ etablissement.titre }}</td>
							<td>{{ etablissement.titre_ar }}</td>
							<td>{{ etablissement.type }}</td>
							<td>
								<base-button
									simple
									type="primary"
									v-on:click="selectEtablissement(etablissement)"
									>Détails</base-button
								>
							</td>
							<td>
								<base-button
									simple
									type="primary"
									v-on:click="$router.push('/gerer/specialites?etablissement='+etablissement.id)"
									>Spécialités</base-button
								>
							</td>
							<td
								style="min-width: 80px"
								class="td-actions text-right"
								v-if="parseInt(user.role) == 3"
							>
								<base-button
									type="success"
									size="sm"
									icon
									v-on:click="editEtablissementModal(etablissement)"
								>
									<i class="tim-icons icon-settings"></i>
								</base-button>
								<base-button
									type="danger"
									size="sm"
									icon
									v-on:click="deleteEtablissement(etablissement.id)"
								>
									<i class="tim-icons icon-simple-remove"></i>
								</base-button>
							</td>
						</tr>
					</tbody>
				</table>
				<nav aria-label="Page navigation example">
					<ul class="pagination">
						<li class="page-item">
							<button type="button" class="page-link" :disabled="page == 1" @click="page--"> Previous </button>
						</li>
						<!-- <li class="page-item">
							<button type="button" class="page-link" v-for="(pageNumber, index) in pages.slice(page-1, page+5)" :key="index" @click="page = pageNumber"> {{pageNumber}} </button>
						</li> -->
						<li class="page-item">
							<button type="button" @click="page++" :disabled="page == etablissements.length" class="page-link"> Next </button>
						</li>
					</ul>
				</nav>	 
			</div>
			<template slot="footer">
				<!-- <base-button type="success" fill v-on:click="saveDon()">Entregistrer</base-button> -->
			</template>
		</card>
        <modal :show.sync="modals.detailsModal">
            <template slot="header">
                Détails
            </template>
            <template>
                <div class="typography-line text-left">
                <p>
                    <span style="bottom: unset; line-height: unset;">Prentation:</span>
                    {{this.selectedEtablissement.presentation}}&nbsp;
                </p>
                </div>
                <div class="typography-line text-left">
                <p>
                    <span style="bottom: unset; line-height: unset;">Telephone:</span>
                    {{this.selectedEtablissement.telephone}}&nbsp;
                </p>
                </div>
                <div class="typography-line text-left">
                <p>
                    <span style="bottom: unset; line-height: unset;">Fax:</span>
                    {{this.selectedEtablissement.fax}}&nbsp;
                </p>
                </div>
                <div class="typography-line text-left">
                <p>
                    <span style="bottom: unset; line-height: unset;">Nombre<br>d'etudiants:</span>
                    {{this.selectedEtablissement.nb_etudiants}}&nbsp;
                </p>
                </div> 
                <div class="typography-line text-left">
                <p>
                    <span style="bottom: unset; line-height: unset;">Lien:</span>
                    {{this.selectedEtablissement.url}}&nbsp;
                </p>
                </div> 

            </template>
            <template slot="footer">
                <base-button type="secondary" @click="modals.detailsModal = false;"
                    >Fermer</base-button
                >
            </template>
        </modal>
		<!-- Modal Informations Etablissement Ajout | Update -->
		<modal :show.sync="modals.etablissement" class="text-left">
			<template slot="header">
				{{action == 'create' ? 'Ajouter' : 'Modifier' }}
			</template>

			<template>
				<div class="row">
					<div class="col-md-6">
						<base-input
							label="Titre : "
							v-model="etablissementModel.titre"
							type="text"
							placeholder="titre :"
						>
						</base-input>
					</div>
					<div class="col-md-6">
						<base-input
							label="Titre arabe: "
							v-model="etablissementModel.titre_ar"
							type="text"
							placeholder="اسم الجامعة"
						>
						</base-input>
					</div>
				</div>
	
				<base-input
					label="Présentation :"
					v-model="etablissementModel.presentation"
					type="text"
					placeholder="Présentation de l'université à ajouter..."
				>
				</base-input>

				<div class="row">
					<div class="col-md-6">
						<base-input label="Type">
							<select
								class="form-control "
							v-model="etablissementModel.type"
							>
								<option value="publique" selected>Publique</option>
								<option value="prive" >Privé</option>
								>
							</select>
						</base-input>
					</div>
					<div class="col-md-6">
						<base-input
							label="Catégorie: "
							v-model="etablissementModel.categorie"
							type="text"
							placeholder="Catégorie de l'etablissement"
						>
						</base-input>
					</div>
				</div>
                <base-input label="Université" v-if="etablissementModel.type == 'publique'">
                    <select
                        class="form-control "
                        v-model="etablissementModel.universite_id"
                    >
                        <option
                            v-for="(universite, index) in universites"
                            :value="universite.id"
                            :key="index"
                            >{{ universite.titre }}</option
                        >
                    </select>
                </base-input>
				<div class="row">
					<div class="col-md-6">
						<base-input
							label="Télephone: "
							v-model="etablissementModel.telephone"
							type="number"
							placeholder="Numéro de téléphone"
						>
						</base-input>
					</div>
					<div class="col-md-6">
						<base-input
							label="Fax: "
							v-model="etablissementModel.fax"
							type="number"
							placeholder="Numéro de Fax"
						>
						</base-input>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<base-input
							label="Nombre des étudiants: "
							v-model="etablissementModel.nb_etudiants"
							type="number"
							placeholder="Nombre des étudiants"
						>
						</base-input>
					</div>
					<div class="col-md-6">
						<base-input
							label="Lien: "
							v-model="etablissementModel.url"
							type="text"
							placeholder="Lien internet de l'université"
						>
						</base-input>
					</div>
				</div>
				<base-button
					type="info"
					class="btn-block"
					fill
					v-on:click="modals.adresse = true;"
					>Informations de l'adresse</base-button
				>
			</template>
			<template slot="footer">
				<base-button type="secondary" @click="modals.etablissement = false"
					>Annuler</base-button
				>
				<base-button type="primary" @click="actionEtablissement">{{action == 'create' ? 'Ajouter' : 'Modifier' }}</base-button>
			</template>
		</modal>
		<!-- Modal Informations Adresse -->
		<modal :show.sync="modals.adresse" class="text-left">
			<template slot="header">
				Informations de l'adresse
			</template>

			<template>
                <base-input label="Gouvernorat">
                    <select
                        class="form-control "
                        v-model="adresse.gouvernorat"
                    >
                        <option
                            v-for="(gouvernorat, index) in gouvernorats"
                            :value="gouvernorat.fr"
                            :key="index"
                            >{{ gouvernorat.fr }}</option
                        >
                    </select>
                </base-input>
				<div class="row">
					<div class="col-md-6">
						<base-input
							label="Latiude : "
							v-model="adresse.latitude"
							type="number"
							placeholder="Latiude"
						>
						</base-input>
					</div>
					<div class="col-md-6">
						<base-input
							label="longitude: "
							v-model="adresse.longitude"
							type="number"
							placeholder="Longitude."
						>
						</base-input>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<base-input
							label="Ville: "
							v-model="adresse.ville"
							type="text"
							placeholder="Ville"
						>
						</base-input>
					</div>
					<div class="col-md-6">
						<base-input
							label="Numero: "
							v-model="adresse.numero"
							type="text"
							placeholder="Numero"
						>
						</base-input>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<base-input
							label="Code postale :"
							v-model="adresse.code_postale"
							type="number"
							placeholder="Code postale"
						>
						</base-input>
					</div>
					<div class="col-md-6">
						<base-input
							label="Rue: "
							v-model="adresse.rue"
							type="text"
							placeholder="Rue"
						>
						</base-input>
					</div>
				</div>


			</template>
			<template slot="footer">
				<base-button type="primary" @click="modals.adresse = false">Fermer</base-button>
			</template>
		</modal>


	</div>
</template>
<script>
import { Card, BaseInput } from "../../components/index";

import BaseButton from "../../components/BaseButton";
import BaseTable from "../../components/BaseTable";
import { Modal } from "../../components/index";
export default {
	components: {
		Card,
		BaseInput,
		BaseButton,
		BaseTable,
		Modal
	},
	data() {
		return {
			modals: {
				adresse: false,
				detailsModal: false,
				etablissement: false,
				deleteEtablissement: false
			},
			loading: true,
			etablissementModel: {type: 'publique'},
			action: "create",
            selectedEtablissement: {},
			adresse: {gouvernorat: 'Ariana'},
			filtres:{
				gouvernorat: '',
				universite: ''
			},
			page: 1,
		};
	},
	methods: {
        selectEtablissement(etablissement){
            this.selectedEtablissement = etablissement;
            this.modals.detailsModal = true;
        },
        initEtablissementModal(){
            this.action = 'create';
            this.etablissementModel = {type: 'publique'};
            this.adresse = {gouvernorat: 'Ariana'};
            this.modals.etablissement = true;
        },
        editEtablissementModal(etablissement){
            this.action = 'update';
            this.etablissementModel = etablissement;
            this.adresse = etablissement.adresse ? etablissement.adresse : {gouvernorat: 'Ariana'};
            this.modals.etablissement = true;
        },
		actionEtablissement() {
            // validation
			if (this.action == "create") {
				this.$store
					.dispatch("createEtablissement", {etablissement: this.etablissementModel, adresse: this.adresse})
					.then(response => {
						//console.log(response);
						this.$notify({
							icon: "tim-icons icon-bell-55",
							horizontalAlign: "right",
							verticalAlign: "top",
							type: "success",
							timeout: 4000,
							message: "Nouveau etablissement crée!"
						});
						this.modals.etablissement = false;
					});
			} else if (this.action == "update") {
				this.$store
					.dispatch("updateEtablissement", {etablissement: this.etablissementModel, adresse: this.adresse})
					.then(response => {
						//console.log(response);
						this.$notify({
							icon: "tim-icons icon-bell-55",
							horizontalAlign: "right",
							verticalAlign: "top",
							type: "primary",
							timeout: 4000,
							message: "Etablissement modifié!"
						});
						this.modals.etablissement = false;
					});
			}
		},
		deleteEtablissement(selectedEtablissement) {
            this.$dialog
            .confirm('Etes-vous sûre de supprimer cette université ?', {cancelText: 'Non', okText: 'Oui', customClass:'modal-danger'})
            .then((dialog) => {
			this.$store
				.dispatch("deleteEtablissement", selectedEtablissement)
				.then(response => {
					//console.log(response);
					this.$notify({
						icon: "tim-icons icon-bell-55",
						horizontalAlign: "right",
						verticalAlign: "top",
						type: "danger",
						timeout: 4000,
						message: "Etablissement supprimé!"
					});
				});
            })
            .catch(() => {
            });
        },
        onFiltreGouvernoratChange(event){
            this.$store.dispatch("getEtablissements", 'gouvernorat='+event.target.value).then(response => {
                this.loading = false;
            });
		},
        onFiltreUniversiteChange(event){
            this.$store.dispatch("getEtablissements", 'universite='+event.target.value).then(response => {
                this.loading = false;
            });
		},
        onFiltreAll(){
            this.filtres= {
				gouvernorat: '',
				universite: ''
			};
            this.$store.dispatch("getEtablissements", "").then(response => {
                this.loading = false;
            });
        }
	},
	created() {
		this.$store.dispatch("getEtablissements", "").then(response => {
			this.loading = false;
		});
		this.$store.dispatch("getUniversites", "").then(response => {
			this.loading = false;
		});
	},
	computed: {
		user() {
			return this.$store.getters.user;
		},
		etablissements() {
			return this.$store.getters.etablissements;
		},
		universites() {
			return this.$store.getters.universites;
		},		
		gouvernorats() {
			return this.$store.getters.gouvernorats;
		}
	}
};
</script>
<style scoped>
.page-link{
  display : unset;
  color: black;
}
.pagination{
  justify-content: center;
}
.page-link:disabled:hover{
  background: unset;
}
.page-link:disabled{
  background: rgb(197, 195, 195);
  opacity: 0.7;
}
.noneBg{
  background: transparent !important;
}
.traite{
    background: #32ff7e;
}
.encours{
    background: #18dcff;
}
.nontraite{
    background: #ff8d72;
}

.tim-icons .icon-single-02 {
    color:black !important;
}
.input-group-append, .input-group-prepend .input-group-text, .input-group-prepend .input-group-text {
    border-color: rgba(29, 37, 59, 0.5)!important;
}
</style>