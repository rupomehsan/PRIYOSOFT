//app layout
import Layout from "../Layouts/Layout.vue";
//Dashboard
import Dashboard from "../Management/Dashboard/Dashboard.vue";
//SettingsRoutes
import SettingsRoutes from "../Management/Settings/setup/routes.js";
//UserRoutes
import UserRoutes from "../Management/UserManagement/User/setup/routes.js";
import UserRoleRoutes from "../Management/UserManagement/Role/setup/routes.js";
//routes
import TodoListRoutes from '../Management/TodoManagement/TodoList/setup/routes.js';
import TodoGroupRoutes from '../Management/TodoManagement/TodoGroup/setup/routes.js';
import TodoMilestoneRoutes from '../Management/TodoManagement/TodoMilestone/setup/routes.js';
import OrderRoutes from '../Management/OrderManagement/Order/setup/routes.js';
import SubscriberRoutes from '../Management/WebsiteManagement/Subscriber/setup/routes.js';
import ContactLeadRoutes from '../Management/WebsiteManagement/ContactLead/setup/routes.js';
import FaqRoutes from '../Management/WebsiteManagement/Faq/setup/routes.js';
import AboutUsRoutes from '../Management/WebsiteManagement/AboutUs/setup/routes.js';
import BlogPostRoutes from '../Management/WebsiteManagement/BlogPost/setup/routes.js';
import TestimonialRoutes from '../Management/WebsiteManagement/Testimonial/setup/routes.js';
import TeamMemberRoutes from '../Management/WebsiteManagement/TeamMember/setup/routes.js';
import SiteSectionRoutes from '../Management/WebsiteManagement/SiteSection/setup/routes.js';
import HeroSectionRoutes from '../Management/WebsiteManagement/HeroSection/setup/routes.js';
import TransactionLogRoutes from '../Management/FinanceManagement/TransactionLog/setup/routes.js';
import ProfitDistributionRoutes from '../Management/FinanceManagement/ProfitDistribution/setup/routes.js';
import AccountTransferRoutes from '../Management/FinanceManagement/AccountTransfer/setup/routes.js';
import WithdrawalRoutes from '../Management/FinanceManagement/Withdrawal/setup/routes.js';
import InvestmentRoutes from '../Management/FinanceManagement/Investment/setup/routes.js';
import ExpenseRoutes from '../Management/FinanceManagement/Expense/setup/routes.js';
import IncomeRoutes from '../Management/FinanceManagement/Income/setup/routes.js';
import InvestorRoutes from '../Management/FinanceManagement/Investor/setup/routes.js';
import ExpenseCategoryRoutes from '../Management/FinanceManagement/ExpenseCategory/setup/routes.js';
import IncomeCategoryRoutes from '../Management/FinanceManagement/IncomeCategory/setup/routes.js';
import AccountRoutes from '../Management/FinanceManagement/Account/setup/routes.js';
import ProductRoutes from '../Management/ProductManagement/Product/setup/routes.js';
import ProductGroupRoutes from '../Management/ProductManagement/ProductGroup/setup/routes.js';

const routes = {
  path: "",
  component: Layout,
  children: [
    {
      path: "dashboard",
      component: Dashboard,
      name: "adminDashboard",
    },
    //management routes
        TodoListRoutes,
        TodoGroupRoutes,
        TodoMilestoneRoutes,
        OrderRoutes,
        SubscriberRoutes,
        ContactLeadRoutes,
        FaqRoutes,
        AboutUsRoutes,
        BlogPostRoutes,
        TestimonialRoutes,
        TeamMemberRoutes,
        SiteSectionRoutes,
        HeroSectionRoutes,
        TransactionLogRoutes,
        ProfitDistributionRoutes,
        AccountTransferRoutes,
        WithdrawalRoutes,
        InvestmentRoutes,
        ExpenseRoutes,
        IncomeRoutes,
        InvestorRoutes,
        ExpenseCategoryRoutes,
        IncomeCategoryRoutes,
        AccountRoutes,
        ProductRoutes,
        ProductGroupRoutes,

    //user routes
    UserRoutes,
    UserRoleRoutes,
    //settings
    SettingsRoutes,
  ],
};

export default routes;
