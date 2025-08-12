<template>
  <div :dir="direction">
    <div v-if="theme === 'frontend'">
      <router-view/>
    </div>

    <div v-else-if="theme === 'backend'">
      <main class="db-main" v-if="logged">
        <BackendNavbarComponent/>
        <BackendMenuComponent/>
        <router-view/>
      </main>
      <div v-else>
        <router-view/>
      </div>
    </div>

    <div v-else-if="theme === 'table'">
      <TableNavBarComponent/>
      <TableCartComponent/>
      <router-view/>
      <TableFooterComponent/>
    </div>
  </div>
</template>

<script>
import BackendNavbarComponent from "./layouts/backend/BackendNavbarComponent.vue";
import BackendMenuComponent   from "./layouts/backend/BackendMenuComponent.vue";

import TableNavBarComponent   from "./layouts/table/TableNavBarComponent.vue";
import TableCartComponent     from "./layouts/table/TableCartComponent.vue";
import TableFooterComponent   from "./layouts/table/TableFooterComponent.vue";

import displayModeEnum        from "../enums/modules/displayModeEnum";
import env                    from "../config/env";

export default {
  name: "DefaultComponent",
  components: {
    BackendNavbarComponent,
    BackendMenuComponent,

    TableNavBarComponent,
    TableCartComponent,
    TableFooterComponent,
  },
  data() {
    return {
      theme: "frontend",
    };
  },
  computed: {
    direction() {
      return this.$store.getters['frontendLanguage/show']
        .display_mode === displayModeEnum.RTL
        ? 'rtl'
        : 'ltr';
    },
    logged() {
      return this.$store.getters.authStatus;
    }
  },
  beforeMount() {
    this.$store.dispatch('frontendSetting/lists')
      .then(res => {
        const { site_default_language, site_default_branch } = res.data.data;
        this.$store.dispatch('frontendLanguage/show', site_default_language);
        this.$store.dispatch("globalState/init", {
          branch_id: site_default_branch,
          language_id: site_default_language
        });
      });

    if (['true','TRUE',true,'1',1].includes(env.DEMO)) {
      this.$store.dispatch("authcheck")
        .then(res => {
          if (!res.data.status && (this.theme === "frontend" || this.theme === "backend")) {
            this.$router.push({ name: "auth.login" });
          }
        });
    }
  },
  watch: {
    $route(to) {
      if (to.meta.isFrontend) {
        this.theme = "frontend";
      } else if (to.meta.isTable) {
        this.theme = "table";
      } else {
        this.theme = "backend";
      }
    }
  }
};
</script>
