<template>
	<div class="content">
		<card>
			<template slot="header">
				<h5 class="title">Gérer les universités</h5>
				<div class="row filtre">
					<div class="col-xl-4">
						<base-input label="Filtrer par gouvernorat">
							<select
								class="form-control "
								@change="onFiltreGouvernoratChange($event)"
                                v-model="filtreGouvernorat"
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
					<div class="col-xl-2">
						<base-button
							style="    margin-top: 23px;"
							type="warning"
							fill
							v-on:click="onFiltreAll()"
							>Voir tous</base-button
						>
					</div>
					<div
						class="col-xl-3"
						v-if="parseInt(user.role) == 3"
					>
						<base-button
							style="   margin-top: 23px;"
							type="success"
							fill
							v-on:click="initUniversiteModal()"
							>Ajouter une nouvelle université</base-button
						>
					</div>
				</div>
			</template>
			<div class="table-responsive">
				<table class="table tablesorter text-left">
					<thead class="text-primary">
						<tr>
							<slot nom="columns">
                                <th>Gouvernorat </th>
								<th>Titre (fr) </th>
								<th>Titre (ar)</th>
                                <th>Détails</th>
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
						<tr v-if="universites.length == 0">
							<td colspan="7">
								<div class="login text-center">
									Aucune donnée trouvée...
								</div>
							</td>
						</tr>
						<tr v-for="(universite, index) in universites" :key="index">
                            <td>{{ universite.adresse ? universite.adresse.gouvernorat : '' }}</td>
							<td>{{ universite.titre }}</td>
							<td>{{ universite.titre_ar }}</td>
							<td>
								<base-button
									simple
									type="primary"
									v-on:click="selectUniversite(universite)"
									>Détails</base-button
								>
							</td>

							<td
								class="td-actions text-right"
								v-if="parseInt(user.role) == 3"
							>
								<base-button
									type="success"
									size="sm"
									icon
									v-on:click="editUniversiteModal(universite)"
								>
									<i class="tim-icons icon-settings"></i>
								</base-button>
								<base-button
									type="danger"
									size="sm"
									icon
									v-on:click="deleteUniversite(universite.id)"
								>
									<i class="tim-icons icon-simple-remove"></i>
								</base-button>
							</td>
						</tr>
					</tbody>
				</table>
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
                    {{this.selectedUniversite.presentation}}&nbsp;
                </p>
                </div>
                <div class="typography-line text-left">
                <p>
                    <span style="bottom: unset; line-height: unset;">Telephone:</span>
                    {{this.selectedUniversite.telephone}}&nbsp;
                </p>
                </div>
                <div class="typography-line text-left">
                <p>
                    <span style="bottom: unset; line-height: unset;">Fax:</span>
                    {{this.selectedUniversite.fax}}&nbsp;
                </p>
                </div>
                <div class="typography-line text-left">
                <p>
                    <span style="bottom: unset; line-height: unset;">Lien:</span>
                    {{this.selectedUniversite.url}}&nbsp;
                </p>
                </div> 

            </template>
            <template slot="footer">
                <base-button type="secondary" @click="modals.detailsModal = false;"
                    >Fermer</base-button
                >
            </template>
        </modal>
		<modal :show.sync="modals.universite" class="text-left">
			<template slot="header">
				{{action == 'create' ? 'Ajouter' : 'Modifier' }}
			</template>

			<template>
				<base-input
					label="Titre : "
					v-model="universiteModel.titre"
					type="text"
					placeholder="titre :"
				>
				</base-input>
				<base-input
					label="Titre arabe: "
					v-model="universiteModel.titre_ar"
					type="text"
					placeholder="اسم الجامعة"
				>
				</base-input>
                <base-input label="Type">
                    <select
                        class="form-control "
                       v-model="universiteModel.type"
                    >
                        <option value="publique" selected>Publique</option>
						<option value="prive" >Privé</option>
                        >
                    </select>
                </base-input>
				<base-input
					label="Présentation :"
					v-model="universiteModel.presentation"
					type="text"
					placeholder="Présentation de l'université à ajouter..."
				>
				</base-input>
				<div class="row">
					<div class="col-md-6">
						<base-input
							label="Télephone: "
							v-model="universiteModel.telephone"
							type="number"
							placeholder="Numéro de téléphone"
						>
						</base-input>
					</div>	
					<div class="col-md-6">
						<base-input
							label="Fax: "
							v-model="universiteModel.fax"
							type="number"
							placeholder="Numéro de Fax"
						>
						</base-input>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<base-input
							label="Lien: "
							v-model="universiteModel.url"
							type="text"
							placeholder="Lien internet de l'université"
						>
						</base-input>
					</div>	
					<div class="col-md-6">
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
					</div>			
				</div>


			</template>
			<template slot="footer">
				<base-button type="secondary" @click="modals.universite = false"
					>Annuler</base-button
				>
				<base-button type="primary" @click="actionUniversite">{{action == 'create' ? 'Ajouter' : 'Modifier' }}</base-button>
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
				detailsModal: false,
				universite: false,
				deleteUniversite: false
			},
			loading: true,
			universiteModel: {type:'publique'},
			action: "create",
            selectedUniversite: {},
            adresse: {gouvernorat: 'Ariana'},
            filtreGouvernorat: ''
		};
	},
	methods: {
        selectUniversite(universite){
            this.selectedUniversite = universite;
            this.modals.detailsModal = true;
        },
        initUniversiteModal(){
            this.action = 'create';
            this.universiteModel = {type:'publique'};
            this.adresse = {gouvernorat: 'Ariana'};
            this.modals.universite = true;
        },
        editUniversiteModal(universite){
            this.action = 'update';
            this.universiteModel = universite;
            this.adresse = universite.adresse ? {gouvernorat: universite.adresse.gouvernorat} : {gouvernorat: 'Ariana'};
            this.modals.universite = true;
        },
		actionUniversite() {
            // validation

			if (this.action == "create") {
				this.$store
					.dispatch("createUniversite", {universite: this.universiteModel, adresse: this.adresse})
					.then(response => {
						//console.log(response);
						this.$notify({
							icon: "tim-icons icon-bell-55",
							horizontalAlign: "right",
							verticalAlign: "top",
							type: "success",
							timeout: 4000,
							message: "Nouvelle université crée!"
						});
						this.modals.universite = false;
					});
			} else if (this.action == "update") {
				this.$store
					.dispatch("updateUniversite", {universite: this.universiteModel, adresse: this.adresse})
					.then(response => {
						//console.log(response);
						this.$notify({
							icon: "tim-icons icon-bell-55",
							horizontalAlign: "right",
							verticalAlign: "top",
							type: "primary",
							timeout: 4000,
							message: "Université modifiée!"
						});
						this.modals.universite = false;
					});
			}
		},
		deleteUniversite(selectedUniversite) {
            this.$dialog
            .confirm('Etes-vous sûre de supprimer cette université ?', {cancelText: 'Non', okText: 'Oui', customClass:'modal-danger'})
            .then((dialog) => {
			this.$store
				.dispatch("deleteUniversite", selectedUniversite)
				.then(response => {
					//console.log(response);
					this.$notify({
						icon: "tim-icons icon-bell-55",
						horizontalAlign: "right",
						verticalAlign: "top",
						type: "danger",
						timeout: 4000,
						message: "Université supprimée!"
					});
				});
            })
            .catch(() => {
            });
        },
        onFiltreGouvernoratChange(event){
            this.$store.dispatch("getUniversites", 'gouvernorat='+event.target.value).then(response => {
                this.loading = false;
            });
        },
        onFiltreAll(){
            this.filtreGouvernorat = '';
            this.$store.dispatch("getUniversites", "").then(response => {
                this.loading = false;
            });
        }
	},
	created() {
		this.$store.dispatch("getUniversites", "").then(response => {
			this.loading = false;
		});
	},
	computed: {
		user() {
			return this.$store.getters.user;
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
