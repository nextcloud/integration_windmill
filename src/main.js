import { createApp } from 'vue'
import App from './App.vue'
import { translate, translatePlural } from '@nextcloud/l10n'

const app = createApp(App)
	app.mixin({
		methods: {
			t: translate,
			n: translatePlural,
		},
		computed: {
			OCA() {
				return window.OCA
			},
			OC() {
				return window.OC
			},
		},
	})
	app.mount('#integration_windmill')
