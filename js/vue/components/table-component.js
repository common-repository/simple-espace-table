import Vue from 'vue';

Vue.component('espace-table-component', {
	created() {
		this.tableData = JSON.parse(this.table_data);
	},
	methods: {
		openTableDataPopup(id) {
			const singleTableData = this.getTableDataByID(id);
			if (!singleTableData) {
				return;
			}

			VueBus.$emit('openTableDataPopup', singleTableData);
		},
		getTableDataByID(id) {
			if (!this.tableData.length) {
				return undefined;
			}

			const parsedID = parseInt(id);

			let singleTableData = {};

			for (let tableDataIndex = 0; tableDataIndex < this.tableData.length; tableDataIndex++) {
				const localTableData = this.tableData[tableDataIndex];

				// if table data id matches
				// set the table data
				if (localTableData.table_data_id === parsedID) {
					singleTableData = Object.assign(localTableData);
					break;
				}
			}

			return singleTableData;
		}
	},
	data() {
		return {
			tableData: []
		};
	},
	props: ['table_data']
});