<template>
    <div class="container-fluid">
        <div class="row pt-2 pb-2">
            <div class="col-sm-9">
                <h4 class="page-title">Site Settings</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10">
                <div class="card" id="site_settings">
                    <div class="card-body">
                        <div class="d-flex">
                            <ul
                                class="flex-column nav nav-tabs nav-tabs-primary top-icon nav-justified card"
                            >
                                <li
                                    class="nav-item"
                                    @click="tab = 'bassic_settings'"
                                >
                                    <a
                                        :class="
                                            tab == 'bassic_settings'
                                                ? ' active'
                                                : ''
                                        "
                                        href="javascript:void();"
                                        data-target="#bassic_settings"
                                        data-toggle="pill"
                                        class="nav-link"
                                        ><i class="icon-note"></i>
                                        <span class="hidden-xs"
                                            >Basic Settings</span
                                        ></a
                                    >
                                    <hr />
                                </li>
                                <li
                                    class="nav-item"
                                    @click="tab = 'seo_settings'"
                                >
                                    <a
                                        :class="
                                            tab == 'seo_settings'
                                                ? 'active'
                                                : ''
                                        "
                                        href="javascript:void();"
                                        data-target="#seo_settings"
                                        data-toggle="pill"
                                        class="nav-link"
                                        ><i class="icon-note"></i>
                                        <span class="hidden-xs"
                                            >SEO Settings</span
                                        ></a
                                    >
                                    <hr />
                                </li>

                                <li
                                    class="nav-item"
                                    @click="tab = 'social_link'"
                                >
                                    <a
                                        :class="
                                            tab == 'social_link'
                                                ? ' active'
                                                : ''
                                        "
                                        href="javascript:void();"
                                        data-target="#social_link"
                                        data-toggle="pill"
                                        class="nav-link"
                                        ><i class="icon-note"></i>
                                        <span class="hidden-xs"
                                            >Social Links information</span
                                        ></a
                                    >
                                    <hr />
                                </li>
                                <li class="nav-item" @click="tab = 'smtp'">
                                    <a
                                        :class="tab == 'smtp' ? ' active' : ''"
                                        href="javascript:void();"
                                        data-target="#smtp"
                                        data-toggle="pill"
                                        class="nav-link"
                                        ><i class="icon-note"></i>
                                        <span class="hidden-xs"
                                            >SMTP Settings</span
                                        ></a
                                    >
                                    <hr />
                                </li>
                                <li class="nav-item" @click="tab = 'payment_settings'">
                                    <a
                                        :class="tab == 'payment_settings' ? ' active' : ''"
                                        href="javascript:void();"
                                        data-target="#payment_settings"
                                        data-toggle="pill"
                                        class="nav-link"
                                        ><i class="icon-credit-card"></i>
                                        <span class="hidden-xs"
                                            >Mobile Banking</span
                                        ></a
                                    >
                                    <hr />
                                </li>
                                <li class="nav-item" @click="tab = 'card_payment'">
                                    <a
                                        :class="tab == 'card_payment' ? ' active' : ''"
                                        href="javascript:void();"
                                        data-target="#card_payment"
                                        data-toggle="pill"
                                        class="nav-link"
                                        ><i class="icon-credit-card"></i>
                                        <span class="hidden-xs"
                                            >Card Payment</span
                                        ></a
                                    >
                                    <hr />
                                </li>
                            </ul>
                            <div class="ml-2 flex-grow-1 tab-content p-3 card">
                                <div
                                    v-if="tab == 'bassic_settings'"
                                    :class="
                                        tab == 'bassic_settings'
                                            ? ' active'
                                            : ''
                                    "
                                    class="tab-pane active"
                                    id="bassic_settings"
                                >
                                    <form @submit.prevent="SiteSettingsHandler"
                                        enctype="multipart/form-data"
                                    >
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >Site Name</label
                                            >
                                            <div class="col-lg-9">
                                                <input
                                                    name="site_name"
                                                    class="form-control"
                                                    type="text"
                                                    :value="`${get_setting_value(
                                                        'site_name'
                                                    )}`"
                                                    placeholder="Enter site name"
                                                />
                                            </div>
                                        </div>

                                        <!-- Email -->
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >Email</label
                                            >
                                            <div class="col-lg-9">
                                                <input
                                                    name="email"
                                                    class="form-control"
                                                    type="email"
                                                    placeholder="Enter email address"
                                                    :value="`${get_setting_value(
                                                        'email'
                                                    )}`"
                                                />
                                            </div>
                                        </div>

                                        <!-- Phone Number -->
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >Phone Number</label
                                            >
                                            <div class="col-lg-9">
                                                <input
                                                    name="phone_numbers"
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="Enter phone number"
                                                    :value="`${get_setting_value(
                                                        'phone_numbers'
                                                    )}`"
                                                />
                                            </div>
                                        </div>

                                        <!-- Website -->
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >Website</label
                                            >
                                            <div class="col-lg-9">
                                                <input
                                                    name="website"
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="Enter company website"
                                                    :value="`${get_setting_value(
                                                        'website'
                                                    )}`"
                                                />
                                            </div>
                                        </div>

                                        <!-- Fax Number (Optional) -->
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >Fax Number</label
                                            >
                                            <div class="col-lg-9">
                                                <input
                                                    name="fax_number"
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="Enter fax number (optional)"
                                                    :value="`${get_setting_value(
                                                        'fax_number'
                                                    )}`"
                                                />
                                            </div>
                                        </div>
                                        <!-- Address -->
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >Address</label
                                            >
                                            <div class="col-lg-9">
                                                <textarea
                                                    name="address"
                                                    class="form-control"
                                                    rows="3"
                                                    placeholder="Enter company address"
                                                    :value="`${get_setting_value(
                                                        'address'
                                                    )}`"
                                                ></textarea>
                                            </div>
                                        </div>

                                        <!-- Copyright -->
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >Copyright Text</label
                                            >
                                            <div class="col-lg-9">
                                                <input
                                                    name="copy_right"
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="e.g. © 2024 Your Company. All rights reserved."
                                                    :value="`${get_setting_value(
                                                        'copy_right'
                                                    )}`"
                                                />
                                            </div>
                                        </div>

                                        <!-- Map Link -->
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >Google Map Embed</label
                                            >
                                            <div class="col-lg-9">
                                                <textarea
                                                    name="map_link"
                                                    class="form-control"
                                                    rows="3"
                                                    placeholder="Paste Google Maps iframe embed code"
                                                    :value="`${get_setting_value(
                                                        'map_link'
                                                    )}`"
                                                ></textarea>
                                            </div>
                                        </div>

                                        <!-- Header Logo -->
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >Header Logo</label
                                            >
                                            <div class="col-lg-9">
                                                <input
                                                    class="form-control"
                                                    name="header_logo"
                                                    type="file"
                                                />
                                                <img
                                                    v-if="get_setting_value('header_logo')"
                                                    class="mt-2"
                                                    :src="`/${get_setting_value('header_logo')}`"
                                                    height="60"
                                                    alt="Header Logo"
                                                />
                                            </div>
                                        </div>

                                        <!-- Footer Logo -->
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >Footer Logo</label
                                            >
                                            <div class="col-lg-9">
                                                <input
                                                    class="form-control"
                                                    name="footer_logo"
                                                    type="file"
                                                />
                                                <img
                                                    v-if="get_setting_value('footer_logo')"
                                                    class="mt-2"
                                                    :src="`/${get_setting_value('footer_logo')}`"
                                                    height="60"
                                                    alt="Footer Logo"
                                                />
                                            </div>
                                        </div>

                                        <!-- Favicon -->
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >Favicon</label
                                            >
                                            <div class="col-lg-9">
                                                <input
                                                    class="form-control"
                                                    name="fabicon"
                                                    type="file"
                                                />
                                                <img
                                                    v-if="get_setting_value('fabicon')"
                                                    class="mt-2"
                                                    :src="`/${get_setting_value('fabicon')}`"
                                                    height="32"
                                                    width="32"
                                                    alt="Favicon"
                                                />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                            ></label>
                                            <div class="col-lg-9">
                                                <input
                                                    type="submit"
                                                    class="btn btn-primary"
                                                    value="Save Changes"
                                                />
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div
                                    v-if="tab == 'seo_settings'"
                                    :class="
                                        tab == 'seo_settings' ? ' active' : ''
                                    "
                                    class="tab-pane"
                                    id="seo_settings"
                                >
                                    <form @submit.prevent="SiteSettingsHandler">
                                        <!-- Meta Title -->
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >Meta Title</label
                                            >
                                            <div class="col-lg-9">
                                                <input
                                                    name="meta_title"
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="Enter meta title"
                                                    :value="`${get_setting_value(
                                                        'meta_title'
                                                    )}`"
                                                />
                                            </div>
                                        </div>

                                        <!-- Meta Description -->
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >Meta Description</label
                                            >
                                            <div class="col-lg-9">
                                                <textarea
                                                    name="meta_description"
                                                    class="form-control"
                                                    rows="3"
                                                    placeholder="Enter meta description"
                                                    :value="`${get_setting_value(
                                                        'meta_description'
                                                    )}`"
                                                >
                                                </textarea>
                                            </div>
                                        </div>

                                        <!-- Meta Keywords -->
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >Meta Keywords</label
                                            >
                                            <div class="col-lg-9">
                                                <input
                                                    name="meta_keywords"
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="Enter meta keywords (comma-separated)"
                                                    :value="`${get_setting_value(
                                                        'meta_keywords'
                                                    )}`"
                                                />
                                            </div>
                                        </div>

                                        <!-- Canonical URL -->
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >Canonical URL</label
                                            >
                                            <div class="col-lg-9">
                                                <input
                                                    name="canonical_url"
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="https://yoursite.com"
                                                    :value="`${get_setting_value(
                                                        'canonical_url'
                                                    )}`"
                                                />
                                            </div>
                                        </div>

                                        <!-- OG Image -->
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >OG Image</label
                                            >
                                            <div class="col-lg-9">
                                                <input
                                                    class="form-control"
                                                    name="seo_image"
                                                    type="file"
                                                />
                                                <small class="text-muted">Used for Open Graph / social sharing preview (recommended 1200×630px)</small>
                                                <img
                                                    v-if="get_setting_value('seo_image')"
                                                    class="mt-2 d-block"
                                                    :src="`/${get_setting_value('seo_image')}`"
                                                    height="80"
                                                    alt="OG Image"
                                                />
                                            </div>
                                        </div>

                                        <!-- Meta Tag -->
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >Meta Tags</label
                                            >
                                            <div class="col-lg-9">
                                                <textarea
                                                    name="meta_tag"
                                                    class="form-control"
                                                    rows="4"
                                                    placeholder="Paste custom <meta> tags here"
                                                    :value="`${get_setting_value(
                                                        'meta_tag'
                                                    )}`"
                                                ></textarea>
                                                <small class="text-muted">These tags will be injected into the &lt;head&gt; section</small>
                                            </div>
                                        </div>

                                        <!-- Schema Markup -->
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >Schema Markup</label
                                            >
                                            <div class="col-lg-9">
                                                <textarea
                                                    name="meta_schema_tag"
                                                    class="form-control"
                                                    rows="5"
                                                    placeholder='{"@context":"https://schema.org","@type":"Organization",...}'
                                                    :value="`${get_setting_value(
                                                        'meta_schema_tag'
                                                    )}`"
                                                ></textarea>
                                                <small class="text-muted">JSON-LD structured data for rich search results</small>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                            ></label>
                                            <div class="col-lg-9">
                                                <input
                                                    type="submit"
                                                    class="btn btn-primary"
                                                    value="Save Changes"
                                                />
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div
                                    v-if="tab == 'social_link'"
                                    :class="
                                        tab == 'social_link' ? ' active' : ''
                                    "
                                    class="tab-pane"
                                    id="social_link"
                                >
                                    <form @submit.prevent="SiteSettingsHandler">
                                        <!-- Facebook -->
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >Facebook</label
                                            >
                                            <div class="col-lg-9">
                                                <input
                                                    name="facebook"
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="https://facebook.com/yourpage"
                                                    :value="`${get_setting_value(
                                                        'facebook'
                                                    )}`"
                                                />
                                            </div>
                                        </div>
                                        <!-- Twitter -->
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >Twitter</label
                                            >
                                            <div class="col-lg-9">
                                                <input
                                                    name="twitter"
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="https://twitter.com/yourprofile"
                                                    :value="`${get_setting_value(
                                                        'twitter'
                                                    )}`"
                                                />
                                            </div>
                                        </div>
                                        <!-- Instagram -->
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >Instagram</label
                                            >
                                            <div class="col-lg-9">
                                                <input
                                                    name="instagram"
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="https://instagram.com/yourprofile"
                                                    :value="`${get_setting_value(
                                                        'instagram'
                                                    )}`"
                                                />
                                            </div>
                                        </div>
                                        <!-- LinkedIn -->
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >LinkedIn</label
                                            >
                                            <div class="col-lg-9">
                                                <input
                                                    name="linkedin"
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="https://linkedin.com/in/yourprofile"
                                                    :value="`${get_setting_value(
                                                        'linkedin'
                                                    )}`"
                                                />
                                            </div>
                                        </div>
                                        <!-- YouTube -->
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >YouTube</label
                                            >
                                            <div class="col-lg-9">
                                                <input
                                                    name="youtube"
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="https://youtube.com/yourchannel"
                                                    :value="`${get_setting_value(
                                                        'youtube'
                                                    )}`"
                                                />
                                            </div>
                                        </div>
                                        <!-- WhatsApp -->
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >WhatsApp</label
                                            >
                                            <div class="col-lg-9">
                                                <input
                                                    name="whatsapp"
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="https://wa.me/1234567890"
                                                    :value="`${get_setting_value(
                                                        'whatsapp'
                                                    )}`"
                                                />
                                            </div>
                                        </div>
                                        <!-- Telegram -->
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >Telegram</label
                                            >
                                            <div class="col-lg-9">
                                                <input
                                                    name="telegram"
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="https://t.me/yourusername"
                                                    :value="`${get_setting_value(
                                                        'telegram'
                                                    )}`"
                                                />
                                            </div>
                                        </div>
                                        <!-- Pinterest -->
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >Pinterest</label
                                            >
                                            <div class="col-lg-9">
                                                <input
                                                    name="pinterest"
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="https://pinterest.com/yourprofile"
                                                    :value="`${get_setting_value(
                                                        'pinterest'
                                                    )}`"
                                                />
                                            </div>
                                        </div>
                                        <!-- TikTok -->
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >TikTok</label
                                            >
                                            <div class="col-lg-9">
                                                <input
                                                    name="tiktok"
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="https://tiktok.com/@yourusername"
                                                    :value="`${get_setting_value(
                                                        'tiktok'
                                                    )}`"
                                                />
                                            </div>
                                        </div>
                                        <!-- Save Button -->
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                            ></label>
                                            <div class="col-lg-9">
                                                <input
                                                    type="submit"
                                                    class="btn btn-primary"
                                                    value="Save Changes"
                                                />
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div
                                    v-if="tab == 'smtp'"
                                    :class="tab == 'smtp' ? ' active' : ''"
                                    class="tab-pane"
                                    id="smtp"
                                >
                                    <form @submit.prevent="SiteSettingsHandler">
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >Host</label
                                            >
                                            <div class="col-lg-9">
                                                <input
                                                    name="mail_host"
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="mail.example.com"
                                                    :value="`${get_setting_value(
                                                        'mail_host'
                                                    )}`"
                                                />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >Port</label
                                            >
                                            <div class="col-lg-9">
                                                <input
                                                    name="mail_port"
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="465"
                                                    :value="`${get_setting_value(
                                                        'mail_port'
                                                    )}`"
                                                />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >Username</label
                                            >
                                            <div class="col-lg-9">
                                                <input
                                                    name="mail_username"
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="mainaccount@example.com"
                                                    :value="`${get_setting_value(
                                                        'mail_username'
                                                    )}`"
                                                />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >Password</label
                                            >
                                            <div class="col-lg-9">
                                                <input
                                                    name="mail_password"
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="*********"
                                                    :value="`${get_setting_value(
                                                        'mail_password'
                                                    )}`"
                                                />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                                >Encryption</label
                                            >
                                            <div class="col-lg-9">
                                                <select
                                                    name="mail_encryption"
                                                    class="form-control"
                                                    :value="`${get_setting_value(
                                                        'mail_encryption'
                                                    )}`"
                                                >
                                                    <option value="ssl">
                                                        SSL
                                                    </option>
                                                    <option value="tls">
                                                        TLS
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Save Button -->
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-3 col-form-label form-control-label"
                                            ></label>
                                            <div class="col-lg-9">
                                                <input
                                                    type="submit"
                                                    class="btn btn-primary"
                                                    value="Save Details"
                                                />
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div
                                    v-if="tab == 'payment_settings'"
                                    :class="tab == 'payment_settings' ? ' active' : ''"
                                    class="tab-pane"
                                    id="payment_settings"
                                >
                                    <form @submit.prevent="SiteSettingsHandler">

                                        <!-- bKash -->
                                        <h6 class="mb-3 text-muted font-weight-bold">bKash</h6>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label form-control-label">Account Number</label>
                                            <div class="col-lg-9">
                                                <input
                                                    name="bkash_number"
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="01XXXXXXXXX"
                                                    :value="`${get_setting_value('bkash_number')}`"
                                                />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label form-control-label">Account Type</label>
                                            <div class="col-lg-9">
                                                <select name="bkash_account_type" class="form-control">
                                                    <option value="Personal" :selected="get_setting_value('bkash_account_type') == 'Personal'">Personal</option>
                                                    <option value="Merchant" :selected="get_setting_value('bkash_account_type') == 'Merchant'">Merchant</option>
                                                </select>
                                            </div>
                                        </div>

                                        <hr />

                                        <!-- Nagad -->
                                        <h6 class="mb-3 text-muted font-weight-bold">Nagad</h6>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label form-control-label">Account Number</label>
                                            <div class="col-lg-9">
                                                <input
                                                    name="nagad_number"
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="01XXXXXXXXX"
                                                    :value="`${get_setting_value('nagad_number')}`"
                                                />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label form-control-label">Account Type</label>
                                            <div class="col-lg-9">
                                                <select name="nagad_account_type" class="form-control">
                                                    <option value="Personal" :selected="get_setting_value('nagad_account_type') == 'Personal'">Personal</option>
                                                    <option value="Merchant" :selected="get_setting_value('nagad_account_type') == 'Merchant'">Merchant</option>
                                                </select>
                                            </div>
                                        </div>

                                        <hr />

                                        <!-- Rocket -->
                                        <h6 class="mb-3 text-muted font-weight-bold">Rocket</h6>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label form-control-label">Account Number</label>
                                            <div class="col-lg-9">
                                                <input
                                                    name="rocket_number"
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="01XXXXXXXXX"
                                                    :value="`${get_setting_value('rocket_number')}`"
                                                />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label form-control-label">Account Type</label>
                                            <div class="col-lg-9">
                                                <select name="rocket_account_type" class="form-control">
                                                    <option value="Personal" :selected="get_setting_value('rocket_account_type') == 'Personal'">Personal</option>
                                                    <option value="Merchant" :selected="get_setting_value('rocket_account_type') == 'Merchant'">Merchant</option>
                                                </select>
                                            </div>
                                        </div>

                                        <hr />

                                        <!-- Bank Account -->
                                        <h6 class="mb-3 text-muted font-weight-bold">Bank Account</h6>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label form-control-label">Bank Name</label>
                                            <div class="col-lg-9">
                                                <input
                                                    name="bank_name"
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="e.g. Dutch Bangla Bank"
                                                    :value="`${get_setting_value('bank_name')}`"
                                                />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label form-control-label">Account Name</label>
                                            <div class="col-lg-9">
                                                <input
                                                    name="bank_account_name"
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="Account holder name"
                                                    :value="`${get_setting_value('bank_account_name')}`"
                                                />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label form-control-label">Account Number</label>
                                            <div class="col-lg-9">
                                                <input
                                                    name="bank_account_number"
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="e.g. 1234567890"
                                                    :value="`${get_setting_value('bank_account_number')}`"
                                                />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label form-control-label">Branch Name</label>
                                            <div class="col-lg-9">
                                                <input
                                                    name="bank_branch_name"
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="e.g. Mirpur Branch"
                                                    :value="`${get_setting_value('bank_branch_name')}`"
                                                />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label form-control-label">Routing Number</label>
                                            <div class="col-lg-9">
                                                <input
                                                    name="bank_routing_number"
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="e.g. 123456789"
                                                    :value="`${get_setting_value('bank_routing_number')}`"
                                                />
                                            </div>
                                        </div>

                                        <!-- Save Button -->
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label form-control-label"></label>
                                            <div class="col-lg-9">
                                                <input
                                                    type="submit"
                                                    class="btn btn-primary"
                                                    value="Save Changes"
                                                />
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- Card Payment Tab -->
                                <div
                                    v-if="tab == 'card_payment'"
                                    :class="tab == 'card_payment' ? ' active' : ''"
                                    class="tab-pane"
                                    id="card_payment"
                                >
                                    <form @submit.prevent="SiteSettingsHandler">

                                        <!-- Payment Gateway -->
                                        <h6 class="mb-3 text-muted font-weight-bold">Payment Gateway</h6>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label form-control-label">Gateway</label>
                                            <div class="col-lg-9">
                                                <select name="card_gateway" class="form-control">
                                                    <option value="sslcommerz" :selected="get_setting_value('card_gateway') == 'sslcommerz'">SSL Commerz</option>
                                                    <option value="stripe" :selected="get_setting_value('card_gateway') == 'stripe'">Stripe</option>
                                                    <option value="paypal" :selected="get_setting_value('card_gateway') == 'paypal'">PayPal</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label form-control-label">Mode</label>
                                            <div class="col-lg-9">
                                                <select name="card_gateway_mode" class="form-control">
                                                    <option value="sandbox" :selected="get_setting_value('card_gateway_mode') == 'sandbox'">Sandbox (Test)</option>
                                                    <option value="live" :selected="get_setting_value('card_gateway_mode') == 'live'">Live</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label form-control-label">Store ID / API Key</label>
                                            <div class="col-lg-9">
                                                <input
                                                    name="card_store_id"
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="Enter Store ID or API Key"
                                                    :value="`${get_setting_value('card_store_id')}`"
                                                />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label form-control-label">Store Password / Secret Key</label>
                                            <div class="col-lg-9">
                                                <input
                                                    name="card_store_password"
                                                    class="form-control"
                                                    type="password"
                                                    placeholder="Enter Store Password or Secret Key"
                                                    :value="`${get_setting_value('card_store_password')}`"
                                                />
                                            </div>
                                        </div>

                                        <hr />

                                        <!-- Accepted Cards -->
                                        <h6 class="mb-3 text-muted font-weight-bold">Accepted Cards</h6>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label form-control-label">Visa</label>
                                            <div class="col-lg-9">
                                                <select name="accept_visa" class="form-control">
                                                    <option value="yes" :selected="get_setting_value('accept_visa') == 'yes'">Yes</option>
                                                    <option value="no" :selected="get_setting_value('accept_visa') == 'no'">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label form-control-label">MasterCard</label>
                                            <div class="col-lg-9">
                                                <select name="accept_mastercard" class="form-control">
                                                    <option value="yes" :selected="get_setting_value('accept_mastercard') == 'yes'">Yes</option>
                                                    <option value="no" :selected="get_setting_value('accept_mastercard') == 'no'">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label form-control-label">American Express</label>
                                            <div class="col-lg-9">
                                                <select name="accept_amex" class="form-control">
                                                    <option value="yes" :selected="get_setting_value('accept_amex') == 'yes'">Yes</option>
                                                    <option value="no" :selected="get_setting_value('accept_amex') == 'no'">No</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Save Button -->
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label form-control-label"></label>
                                            <div class="col-lg-9">
                                                <input
                                                    type="submit"
                                                    class="btn btn-primary"
                                                    value="Save Changes"
                                                />
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End container-fluid-->
</template>

<script>
import { auth_store } from "../../../../GlobalStore/auth_store";
import { site_settings_store } from "../../../../GlobalStore/site_settings_store";
import { mapState, mapActions } from "pinia";
export default {
    data: () => ({
        tab: "bassic_settings",
    }),

    methods: {
        ...mapActions(auth_store, {
            check_is_auth: "check_is_auth",
        }),
        ...mapActions(site_settings_store, {
            get_all_website_settings: "get_all_website_settings",
            get_setting_value: "get_setting_value",
        }),
        SiteSettingsHandler: async function () {
            let formData = new FormData(event.target);
            let response = await axios.post("website-settings/store", formData);
            if (response.data.status == "success") {
                window.s_alert(response.data.message);
                this.get_all_website_settings();
            }
        },

    },
    computed: {
        ...mapState(auth_store, {
            auth_info: "auth_info",
        }),
        ...mapState(site_settings_store, {
            website_settings_data: "website_settings_data",
        }),
    },
    watch: {
        website_settings_data: {
            handler: function () {
                // this.get_all_website_settings();
            },
        },
    },
};
</script>

<style></style>
