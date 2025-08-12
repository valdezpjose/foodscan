<template>
  <LoadingComponent :props="loading" />
  <div class="col-12 xl:col-6">
    <div class="db-card">
      <div class="db-card-header">
        <h3 class="db-card-title">{{ $t('label.order_stats') }}</h3>
        <div id="customer-range" class="cursor-pointer flex items-center gap-3 custom-datepicker">
          <Datepicker
            hideInputIcon
            autoApply
            :enableTimePicker="false"
            utc="false"
            @update:modelValue="customerStates"
            v-model="date"
            range
            :preset-ranges="presetRanges"
          >
            <template #yearly="{ label, range, presetDateRange }">
              <span @click="presetDateRange(range)">{{ label }}</span>
            </template>
          </Datepicker>
          <!-- antes: lab-color-pink -->
          <i class="lab lab-calendar lab-font-size-24 text-primary"></i>
        </div>
      </div>

      <div class="db-card-body">
        <div id="column-chart"></div>
      </div>
    </div>
  </div>
</template>

<script>
import LoadingComponent from "../components/LoadingComponent";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import { endOfMonth, endOfYear, startOfMonth, startOfYear, subMonths, subYears } from 'date-fns';
// import ApexCharts from "apexcharts"; // descomenta si no es global

export default {
  name: "CustomerStatsComponent",
  components: { LoadingComponent, Datepicker },
  data() {
    return {
      loading: { isActive: false },
      date: null,
      first_date: null,
      last_date: null,
      chart: null, // guardar instancia
      presetRanges: [
        { label: 'Today', range: [new Date(), new Date()] },
        { label: 'This month', range: [startOfMonth(new Date()), endOfMonth(new Date())] },
        { label: 'Last month', range: [startOfMonth(subMonths(new Date(), 1)), endOfMonth(subMonths(new Date(), 1))] },
        { label: 'This year', range: [startOfYear(new Date()), endOfYear(new Date())] },
        { label: 'Last year', range: [startOfYear(subYears(new Date(), 1)), endOfYear(subYears(new Date(), 1))] },
      ]
    };
  },
  mounted() {
    const d = new Date();
    const startDate = new Date(d.getFullYear(), d.getMonth(), 1);
    const endDate = new Date(d.getFullYear(), d.getMonth() + 1, 0);
    this.date = [startDate, endDate];
    this.customerStates();
  },
  methods: {
    makeOptions(categories, seriesData) {
      return {
        series: [{ name: this.$t('menu.customers'), data: seriesData }],
        chart: {
          type: 'bar',
          height: 300,
          parentHeightOffset: 0,
          zoom: { enabled: false },
          toolbar: { show: false },
          fontFamily: 'inherit',
        },
        // Barras NARANJAS (primary)
        colors: ['#FF4F20'],
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '45%',
            borderRadius: 4,
          },
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['#1C3168'], // azul marino (secondary) como borde
        },
        grid: { borderColor: '#EBECF3' }, // gris suave
        dataLabels: { enabled: false },
        xaxis: {
          categories,
          axisBorder: { show: false },
          axisTicks: { color: '#EBECF3' },
          labels: { style: { colors: '#667085' } }, // texto gris medio
          tooltip: { enabled: false },
        },
        yaxis: {
          labels: { style: { colors: '#667085' } },
        },
        tooltip: {
          theme: 'light',
          style: { fontSize: '14px', fontFamily: 'inherit' },
        },
        fill: { opacity: 1 },
      };
    },

    customerStates(e) {
      let date = { first_date: '', last_date: '' };
      if (e) {
        this.first_date = e[0];
        this.last_date  = e[1];
        date.first_date = e[0];
        date.last_date  = e[1];
      }

      this.loading.isActive = true;
      this.$store.dispatch("dashboard/customerStates", date)
        .then((res) => {
          const categories = res.data.data.times || [];
          const seriesData = res.data.data.total_customers || [];

          // destruir instancia previa para no superponer
          if (this.chart) {
            this.chart.destroy();
            this.chart = null;
          }

          const options = this.makeOptions(categories, seriesData);
          this.chart = new ApexCharts(document.querySelector("#column-chart"), options);
          this.chart.render();

          this.loading.isActive = false;
        })
        .catch(() => {
          this.loading.isActive = false;
        });
    },
  },
};
</script>
