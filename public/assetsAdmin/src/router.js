import Vue from 'vue'
import Router from 	'vue-router'
import homePage from './views/home.vue'
//站长
import Webmasters from 			'./views/webmaster/webmasters.vue'
import Webmaster from 			'./views/webmaster/webmaster.vue'
import Webmasterads from 		'./views/webmaster/ads.vue'
import Webmasterad from 		'./views/webmaster/ad.vue'
import WebmasterWebsites from 	'./views/webmaster/websites.vue'
import WebmasterCategorys from 	'./views/webmaster/categorys.vue'
import WebmasterMoneys from 	'./views/webmaster/moneys.vue'
import WebmasterLoginlogs from 	'./views/webmaster/loginlogs.vue'
import WebmasterEarningday from 	'./views/webmaster/earningday.vue'
import WebmasterEarningClick from 	'./views/webmaster/earningclick.vue'

//联盟
import Alliances from 	'./views/alliances.vue'
import Alliance from 	'./views/alliance.vue'
import Spendings from 	'./views/spendings.vue'

//联盟
import AllianceFluxs from 	'./views/alliance/fluxs.vue'
import AllianceFluxExpends from	'./views/alliance/fluxexpends.vue'

//广告主
import Advertisers from 		'./views/advertiser/advertisers.vue'
import Advertiser from 			'./views/advertiser/advertiser.vue'
import Advertiserads from 		'./views/advertiser/ads.vue'
import Advertiserad from 		'./views/advertiser/ad.vue'
import AdvertiserConsumes from 	'./views/advertiser/consumes.vue'
import AdvertiserPackages from 	'./views/advertiser/packages.vue'
import AdvertiserPackage from 	'./views/advertiser/package.vue'
import AdvertiserLoginlogs from './views/advertiser/loginlogs.vue'

//财务
import PropertyTakemoneys from 	'./views/property/takemoneys.vue'
import PropertyRewards from 	'./views/property/rewards.vue'
import PropertyRecharges from 	'./views/property/recharges.vue'

import Users from 				'./views/users.vue'
import Departments from './views/departments.vue'
import Setting from './views/setting.vue'
import Messages from './views/messages.vue'

//文章
import Articles from './views/articles.vue'
import ArticleCategorys from './views/article_categorys.vue'

//客户管理
import Customers from './views/customers.vue'
import CustomersSources from './views/customers_sources.vue'
import CustomersMails from './views/customers_mails.vue'

import Mails from './views/mails.vue'

import User from './views/user.vue'

Vue.use(Router)


export default new Router({
	mode: 'history',
	routes: [
		{
			path: '/admin',
		 	component: homePage
		},
		{
			path: '/admin/webmasters',
			component: Webmasters
		},
		{
			name: 'package',
			path: '/admin/webmaster/ads',
			component: Webmasterads
		},
		{
			name: 'package',
			path: '/admin/webmaster/ad/:id',
			component: Webmasterad
		},
		{
			path: '/admin/webmaster/websites',
			component: WebmasterWebsites
		},
		{
			path: '/admin/webmaster/categorys',
			component: WebmasterCategorys
		},
		{
			path: '/admin/webmaster/moneys',
			component: WebmasterMoneys
		},
		{
			path: '/admin/webmaster/loginlogs',
			component: WebmasterLoginlogs
		},
		{
			path: '/admin/webmaster/earningday/:webmaster_ad_id',
			component: WebmasterEarningday
		},
		{
			path: '/admin/webmaster/earningclick/:webmaster_ad_id',
			component: WebmasterEarningClick
		},
		{
			path: '/admin/webmaster/:id',
			component: Webmaster
		},
		{
			path: '/admin/alliance/fluxs',
			component: AllianceFluxs
		},
		{
			path: '/admin/alliance/flux/expends',
			component: AllianceFluxExpends
		},
		{
			path: '/admin/alliances',
			component: Alliances
		},
		{
			path: '/admin/alliance/spendings',
			component: Spendings
		},
		{
			path: '/admin/alliance/:id',
			component: Alliance
		},
		{
			path: '/admin/advertisers',
			component: Advertisers
		},
		{
			path: '/admin/advertiser/ads',
			component: Advertiserads
		},
		{
			path: '/admin/advertiser/ad/:id',
			component: Advertiserad
		},
		{
			path: '/admin/advertiser/ad',
			component: Advertiserad
		},
		{
			path: '/admin/advertiser/consumes',
			component: AdvertiserConsumes
		},
		{
			path: '/admin/advertiser/packages',
			component: AdvertiserPackages
		},
		{
			path: '/admin/advertiser/package/:id',
			component: AdvertiserPackage
		},
		{
			path: '/admin/advertiser/package',
			component: AdvertiserPackage
		},
		{
			path: '/admin/advertiser/loginlogs',
			component: AdvertiserLoginlogs
		},
		{
			path: '/admin/advertiser/:id',
			component: Advertiser
		},
		{
			path: '/admin/property/takemoneys',
			component: PropertyTakemoneys
		},
		{
			path: '/admin/property/rewards',
			component: PropertyRewards
		},
		{
			path: '/admin/property/recharges',
			component: PropertyRecharges
		},
		{
			path: '/admin/users',
			component: Users
		},
		{
			path: '/admin/departments',
			component: Departments
		},
		{
			path: '/admin/setting',
			component: Setting
		},
		{
			path: '/admin/messages',
			component: Messages
		},
		{
			path: '/admin/articles',
			component: Articles
		},
		{
			path: '/admin/article/categorys',
			component: ArticleCategorys
		},
		{
			path: '/admin/customers',
			component: Customers
		},
		{
			path: '/admin/customers/sources',
			component: CustomersSources
		},
		{
			path: '/admin/customers/mails/:customer_id',
			component: CustomersMails
		},
		{
			path: '/admin/mails',
			component: Mails
		},
		{
			path: '/admin/user',
			component: User
		},
  	]
})
