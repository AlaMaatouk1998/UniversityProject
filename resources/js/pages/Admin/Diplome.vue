<template>
	<div class="content">
		<card>
			<template slot="header">
				<h5 class="title">Gérer les diplomes</h5>
				<div class="row filtre">
					<!-- <div class="col-xl-4">
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
					<div class="col-xl-2">
						<base-button
							style="    margin-top: 23px;"
							type="warning"
							fill
							v-on:click="onFiltreAll()"
							>Voir tous</base-button
						>
					</div> -->
					<div
						class="col-xl-3"
						v-if="parseInt(user.role) == 3"
					>
						<base-button
							style="   margin-top: 23px;"
							type="success"
							fill
							v-on:click="initDiplomeModal()"
							>Ajouter un nouveau diplome</base-button
						>
					</div>
				</div>
			</template>
			<div class="table-responsive">
				<table class="table tablesorter text-left">
					<thead class="text-primary">
						<tr>
							<slot nom="columns">
								<th>Titre (fr) </th>
								<th>Titre (ar)</th>
                                <th>Type</th>
                                <th>Niveau</th>
                                <th>Etablissements qui couvre ce diplome</th>
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
						<tr v-if="diplomes.length == 0">
							<td colspan="7">
								<div class="login text-center">
									Aucune donnée trouvée...
								</div>
							</td>
						</tr>
						<tr v-for="(diplome, index) in diplomes" :key="index">
							<td>{{ diplome.titre }}</td>
							<td>{{ diplome.titre_ar }}</td>
                            <td>{{ diplome.type }}</td>
                            <td>{{ diplome.niveau }}</td>
							<td>
								<base-button
									simple
									type="primary"
									v-on:click="selectDiplome(diplome)"
									>Etablissements</base-button
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
									v-on:click="editDiplomeModal(diplome)"
								>
									<i class="tim-icons icon-settings"></i>
								</base-button>
								<base-button
									type="danger"
									size="sm"
									icon
									v-on:click="deleteDiplome(diplome.id)"
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
                Demandé par
            </template>
            <template>
                <div class="typography-line text-left">
                <p>
                    <span style="bottom: unset; line-height: unset;">Prentation:</span>
                    {{this.selectedDiplome.presentation}}&nbsp;
                </p>
                </div>
                <div class="typography-line text-left">
                <p>
                    <span style="bottom: unset; line-height: unset;">Telephone:</span>
                    {{this.selectedDiplome.telephone}}&nbsp;
                </p>
                </div>
                <div class="typography-line text-left">
                <p>
                    <span style="bottom: unset; line-height: unset;">Fax:</span>
                    {{this.selectedDiplome.fax}}&nbsp;
                </p>
                </div>
                <div class="typography-line text-left">
                <p>
                    <span style="bottom: unset; line-height: unset;">Lien:</span>
                    {{this.selectedDiplome.url}}&nbsp;
                </p>
                </div> 

            </template>
            <template slot="footer">
                <base-button type="secondary" @click="modals.detailsModal = false;"
                    >Fermer</base-button
                >
            </template>
        </modal>
		<modal :show.sync="modals.diplome" class="text-left">
			<template slot="header">
				{{action == 'create' ? 'Ajouter' : 'Modifier' }}
			</template>

			<template>
				<base-input
					label="Titre : "
					v-model="diplomeModel.titre"
					type="text"
					placeholder="Titre :"
				>
				</base-input>
				<base-input
					label="Titre arabe: "
					v-model="diplomeModel.titre_ar"
					type="text"
					placeholder="نوع الشهادة"
				>
				</base-input>
				<base-input
					label="Niveau : "
					v-model="diplomeModel.niveau"
					type="text"
					placeholder="Niveau :"
				>
                </base-input>
				<base-input
					label="Type : "
					v-model="diplomeModel.type"
					type="text"
					placeholder="Type :"
				>
				</base-input>
			</template>
			<template slot="footer">
				<base-button type="secondary" @click="modals.diplome = false"
					>Annuler</base-button
				>
				<base-button type="primary" @click="actionDiplome">{{action == 'create' ? 'Ajouter' : 'Modifier' }}</base-button>
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
				diplome: false,
				deleteDiplome: false
			},
			loading: true,
			diplomeModel: {},
			action: "create",
            selectedDiplome: {},
            filtres: {
                gouvernorat: ''
            }
		};
	},
	methods: {
        selectDiplome(diplome){
            this.selectedDiplome = diplome;
            this.modals.detailsModal = true;
        },
        initDiplomeModal(){
            this.action = 'create';
            this.diplomeModel = {};
            this.modals.diplome = true;
        },
        editDiplomeModal(diplome){
            this.action = 'update';
            this.diplomeModel = diplome;
            this.modals.diplome = true;
        },
		actionDiplome() {
            // validation

			if (this.action == "create") {
				this.$store
					.dispatch("createDiplome", {diplome: this.diplomeModel})
					.then(response => {
						//console.log(response);
						this.$notify({
							icon: "tim-icons icon-bell-55",
							horizontalAlign: "right",
							verticalAlign: "top",
							type: "success",
							timeout: 4000,
							message: "Nouveau diplome crée!"
						});
						this.modals.diplome = false;
					});
			} else if (this.action == "update") {
				this.$store
					.dispatch("updateDiplome", {diplome: this.diplomeModel})
					.then(response => {
						//console.log(response);
						this.$notify({
							icon: "tim-icons icon-bell-55",
							horizontalAlign: "right",
							verticalAlign: "top",
							type: "primary",
							timeout: 4000,
							message: "Diplome modifié!"
						});
						this.modals.diplome = false;
					});
			}
		},
		deleteDiplome(selectedDiplome) {
            this.$dialog
            .confirm('Etes-vous sûre de supprimer ce diplome ?', {cancelText: 'Non', okText: 'Oui', customClass:'modal-danger'})
            .then((dialog) => {
			this.$store
				.dispatch("deleteDiplome", selectedDiplome)
				.then(response => {
					//console.log(response);
					this.$notify({
						icon: "tim-icons icon-bell-55",
						horizontalAlign: "right",
						verticalAlign: "top",
						type: "danger",
						timeout: 4000,
						message: "Diplome supprimée!"
					});
				});
            })
            .catch(() => {
            });
        },
        onFiltreGouvernoratChange(event){
            this.$store.dispatch("getDiplomes", 'gouvernorat='+event.target.value).then(response => {
                this.loading = false;
            });
        },
        onFiltreAll(){
            this.filtres.gouvernorat = '';
            this.$store.dispatch("getDiplomes", "").then(response => {
                this.loading = false;
            });
        }
	},
	created() {
		this.$store.dispatch("getDiplomes", "").then(response => {
			this.loading = false;
		});
	},
	computed: {
		user() {
			return this.$store.getters.user;
		},
		diplomes() {
			return this.$store.getters.diplomes;
		},
		gouvernorats() {
			return this.$store.getters.gouvernorats;
		}
	}
};
</script>
