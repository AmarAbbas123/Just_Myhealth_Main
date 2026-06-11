<x-app1>
    <div x-data="loginHistoryReport()" x-init="init()" class="px-6 py-6">
        <x-page-header />

        <div class="grid gap-6 mb-8">
            <div class="bg-white border rounded-xl p-4 shadow-sm">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">User Type</label>
                        <select x-model="selectedUserType"
                            @change="loadUsers"
                            class="mt-2 block w-full rounded-lg border-gray-300 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">-- Select User Type --</option>
                            <template x-for="type in userTypes" :key="type.UserTypeRef">
                                <option :value="type.UserTypeRef" x-text="`${type.UserTypeRef} — ${type.UserTypeDescription}`"></option>
                            </template>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">User</label>
                        <select x-model="selectedUserId"
                            @change="loadReport"
                            :disabled="users.length === 0"
                            class="mt-2 block w-full rounded-lg border-gray-300 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">-- Select User --</option>
                            <template x-for="user in users" :key="user.ID">
                                <option :value="user.ID" x-text="user.UserName"></option>
                            </template>
                        </select>
                    </div>

                </div>
            </div>

            <template x-if="selectedUserId">
                <div class="grid gap-6">
                    <div class="bg-white border rounded-xl p-4 shadow-sm">
                        <h2 class="font-semibold text-lg mb-4">Logon Activity (Last 90 Days)</h2>
                        <div id="chart-logins" class="min-h-[340px]"></div>
                    </div>

                   

                    <div class="bg-white border rounded-xl p-4 shadow-sm">
                        <h2 class="font-semibold text-lg mb-4">Technology View (OS)</h2>
                        <div id="chart-device-os" class="min-h-[380px]"></div>
                    </div>

                    <div class="bg-white border rounded-xl p-4 shadow-sm">
                        <h2 class="font-semibold text-lg mb-4">Technology View (Browser)</h2>
                        <div id="chart-device-browser" class="min-h-[380px]"></div>
                    </div>

                     <div class="bg-white border rounded-xl p-4 shadow-sm">
                        <h2 class="font-semibold text-lg mb-4">Technology View (Device Type)</h2>
                        <div id="chart-device-types" class="min-h-[380px]"></div>
                    </div>
                </div>
            </template>

            <template x-if="!selectedUserId">
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-xl p-4">
                    Select a user type and a user to view login history and device technology trends for the last 90 days.
                </div>
            </template>
        </div>
    </div>

    <script>
        window.loginHistoryReport = function() {
            return {
                userTypes: @json($userTypes),
                users: [],
                selectedUserType: '',
                selectedUserId: '',
                chartLogins: null,
                chartDeviceTypes: null,
                chartDeviceOs: null,
                chartDeviceBrowser: null,
                reportDates: [],

                init() {
                    // no-op until selections are made
                },

                async loadUsers() {
                    this.selectedUserId = '';
                    this.users = [];
                    this.resetCharts();

                    if (!this.selectedUserType) {
                        return;
                    }

                    const res = await fetch(`/mod-02/user-reports/login-history-90days/users/${this.selectedUserType}`);
                    if (!res.ok) {
                        return;
                    }

                    this.users = await res.json();
                },

                async loadReport() {
                    if (!this.selectedUserId) {
                        return;
                    }

                    const res = await fetch(`/mod-02/user-reports/login-history-90days/data?userId=${this.selectedUserId}`);
                    if (!res.ok) {
                        return;
                    }

                        const data = await res.json();
                    this.reportDates = data.dates;
                    this.drawLoginChart(data);
                    this.drawDeviceTypeChart(data);
                    this.drawDeviceOsChart(data);
                    this.drawDeviceBrowserChart(data);
                },

                resetCharts() {
                    if (this.chartLogins) {
                        this.chartLogins.destroy();
                        this.chartLogins = null;
                    }
                    if (this.chartDeviceTypes) {
                        this.chartDeviceTypes.destroy();
                        this.chartDeviceTypes = null;
                    }
                    if (this.chartDeviceOs) {
                        this.chartDeviceOs.destroy();
                        this.chartDeviceOs = null;
                    }
                    if (this.chartDeviceBrowser) {
                        this.chartDeviceBrowser.destroy();
                        this.chartDeviceBrowser = null;
                    }
                },

                drawLoginChart(data) {
                    if (this.chartLogins) {
                        this.chartLogins.updateOptions({
                            xaxis: { categories: data.dates },
                            series: [{ data: data.loginCounts }]
                        });
                        return;
                    }

                    this.chartLogins = new ApexCharts(document.getElementById('chart-logins'), {
                        chart: {
                            type: 'bar',
                            height: 340,
                            zoom: { enabled: false },
                        },
                        plotOptions: {
                            bar: {
                                borderRadius: 4,
                                columnWidth: '60%',
                            }
                        },
                        dataLabels: { enabled: false },
                        series: [{
                            name: 'Logins',
                            data: data.loginCounts,
                        }],
                        xaxis: {
                            categories: data.dates,
                            labels: { rotate: -45, hideOverlappingLabels: true, trim: true },
                        },
                        yaxis: {
                            title: {
                                text: 'Number of Logins',
                                style: {
                                    letterSpacing: '0px',
                                }
                            }
                        },
                        tooltip: {
                            y: { formatter: value => `${value} login${value === 1 ? '' : 's'}` }
                        }
                    });

                    this.chartLogins.render();
                },

                drawDeviceTypeChart(data) {
                    if (this.chartDeviceTypes) {
                        this.chartDeviceTypes.updateOptions({
                            xaxis: { categories: data.dates },
                            series: data.deviceTypeSeries,
                        });
                        return;
                    }

                    this.chartDeviceTypes = new ApexCharts(document.getElementById('chart-device-types'), {
                        chart: {
                            type: 'bar',
                            stacked: true,
                            height: 380,
                        },
                        plotOptions: {
                            bar: { columnWidth: '60%' }
                        },
                        dataLabels: { enabled: false },
                        series: data.deviceTypeSeries,
                        xaxis: {
                            categories: data.dates,
                            labels: { rotate: -45, hideOverlappingLabels: true, trim: true },
                        },
                        yaxis: {
                            title: {
                                text: 'Number of Logins',
                                style: {
                                    letterSpacing: '0px',
                                }
                            }
                        },
                        legend: {
                            position: 'bottom',
                            horizontalAlign: 'center',
                            offsetY: 10,
                        },
                        tooltip: {
                            y: { formatter: value => `${value} login${value === 1 ? '' : 's'}` }
                        }
                    });

                    this.chartDeviceTypes.render();
                },

                drawDeviceOsChart(data) {
                    if (this.chartDeviceOs) {
                        this.chartDeviceOs.updateOptions({
                            xaxis: { categories: data.dates },
                            series: data.deviceOsSeries,
                        });
                        return;
                    }

                    this.chartDeviceOs = new ApexCharts(document.getElementById('chart-device-os'), {
                        chart: {
                            type: 'bar',
                            stacked: true,
                            height: 380,
                        },
                        plotOptions: {
                            bar: { columnWidth: '60%' }
                        },
                        dataLabels: { enabled: false },
                        series: data.deviceOsSeries,
                        xaxis: {
                            categories: data.dates,
                            labels: { rotate: -45, hideOverlappingLabels: true, trim: true },
                        },
                        yaxis: {
                            title: {
                                text: 'Number of Logins',
                                style: {
                                    letterSpacing: '0px',
                                }
                            }
                        },
                        legend: {
                            position: 'bottom',
                            horizontalAlign: 'center',
                            offsetY: 10,
                        },
                        tooltip: {
                            y: { formatter: value => `${value} login${value === 1 ? '' : 's'}` }
                        }
                    });

                    this.chartDeviceOs.render();
                },

                drawDeviceBrowserChart(data) {
                    if (this.chartDeviceBrowser) {
                        this.chartDeviceBrowser.updateOptions({
                            xaxis: { categories: data.dates },
                            series: data.deviceBrowserSeries,
                        });
                        return;
                    }

                    this.chartDeviceBrowser = new ApexCharts(document.getElementById('chart-device-browser'), {
                        chart: {
                            type: 'bar',
                            stacked: true,
                            height: 380,
                        },
                        plotOptions: {
                            bar: { columnWidth: '60%' }
                        },
                        dataLabels: { enabled: false },
                        series: data.deviceBrowserSeries,
                        xaxis: {
                            categories: data.dates,
                            labels: { rotate: -45, hideOverlappingLabels: true, trim: true },
                        },
                        yaxis: {
                            title: {
                                text: 'Number of Logins',
                                style: {
                                    letterSpacing: '0px',
                                }
                            }
                        },
                        legend: {
                            position: 'bottom',
                            horizontalAlign: 'center',
                            offsetY: 10,
                        },
                        tooltip: {
                            y: { formatter: value => `${value} login${value === 1 ? '' : 's'}` }
                        }
                    });

                    this.chartDeviceBrowser.render();
                }
            };
        };
    </script>
</x-app1>
