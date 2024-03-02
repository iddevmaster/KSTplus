<x-app-layout>
    <div class="text-center mt-5">
        <p class="fs-1 fw-bold">Agency Data</p>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="sm:rounded-lg p-4 row justify-center">
                <div class="p-4 rounded-lg row">
                    <div class="col-6 ">
                        <div class="bg-white p-4 shadow rounded-lg">
                            <div class="flex justify-between mb-3">
                                <p class="text-2xl font-bold"><i class="bi bi-buildings"></i> Agency</p>
                                <button class="btn btn-success" onclick="addAgn()" ><i class="bi bi-plus-lg"></i></button>
                            </div>
                            <div class="overflow-auto">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Action</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Address</th>
                                            <th scope="col">Contact</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        @foreach ($agns as $agn)
                                            <tr>
                                                <td>
                                                    <div class="flex gap-1">
                                                        <button class="btn btn-sm btn-danger" id="delBtn" deltype="agn" value="{{ $agn->id }}"><i class="bi bi-trash"></i></button>
                                                        <button
                                                            class="btn btn-sm btn-info text-white"
                                                            id="editBtn"
                                                            edittype="agn"
                                                            value="{{ $agn->id }}"
                                                            agnName="{{$agn->name}}"
                                                            agnAddr="{{$agn->address ?? ''}}"
                                                            agnCont="{{$agn->contact ?? ''}}">
                                                                <i class="bi bi-gear"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="text-nowrap">{{$agn->name}}</td>
                                                <td class="text-nowrap">{{$agn->address?? ""}}</td>
                                                <td class="text-nowrap">{{$agn->contact?? ""}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-white p-4 shadow rounded-lg">
                            <div class="flex justify-between mb-3">
                                <p class="text-2xl font-bold"><i class="bi bi-building"></i> Branch</p>
                                <button class="btn btn-success" onclick="addBrn()"><i class="bi bi-plus-lg"></i></button>
                            </div>
                            <div class="overflow-auto">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Action</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Agency</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        @foreach ($brns as $brn)
                                            <tr>
                                                <td>
                                                    <div class="flex gap-1">
                                                        <button class="btn btn-sm btn-danger" id="delBtn" deltype="brn" value="{{ $brn->id }}"><i class="bi bi-trash"></i></button>
                                                        <button
                                                            class="btn btn-sm btn-info text-white"
                                                            id="editBtn"
                                                            edittype="brn"
                                                            brnName="{{$brn->name}}"
                                                            brnAgn="{{$brn->agency}}"
                                                            value="{{ $brn->id }}">
                                                                <i class="bi bi-gear"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="text-nowrap">{{$brn->name}}</td>
                                                <td class="text-nowrap">{{ optional($brn->agencyName)->name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-lg mb-5 shadow">
                    <div class="flex justify-between mb-3">
                        <p class="text-2xl font-bold"><i class="bi bi-house-door"></i> Department</p>
                        <button class="btn btn-success" onclick="addDpm()"><i class="bi bi-plus-lg"></i></button>
                    </div>
                    <div class="overflow-auto">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Action</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Prefix</th>
                                    <th scope="col">Personnel</th>
                                    <th scope="col">Agency</th>
                                    <th scope="col">Branch</th>
                                </tr>
                            </thead>
                            <tbody >
                                @foreach ($dpms as $dpm)
                                    <tr>
                                        <td>
                                            <div class="flex gap-1">
                                                <button class="btn btn-sm btn-danger" id="delBtn" deltype="dpm" value="{{ $dpm->id }}"><i class="bi bi-trash"></i></button>
                                                <button class="btn btn-sm btn-info text-white"
                                                    id="editBtn"
                                                    edittype="dpm"
                                                    dpmName="{{$dpm->name}}"
                                                    dpmPrefix="{{$dpm->prefix}}"
                                                    dpmBrn="{{$dpm->branch}}"
                                                    value="{{ $dpm->id }}">
                                                        <i class="bi bi-gear"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td>{{$dpm->name}}</td>
                                        <td>{{$dpm->prefix}}</td>
                                            @php
                                                $numPers = App\Models\User::where('dpm', $dpm->id)->count();
                                            @endphp
                                        <td>{{$numPers}}</td>
                                        <td>{{optional($dpm->brnName->agencyName)->name}}</td>
                                        <td>{{optional($dpm->brnName)->name}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="w-4/5 h-0.5 mx-auto border-0 rounded bg-gray-700">

    <div class="text-center mt-5">
        <p class="fs-1 fw-bold">Course Data</p>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="sm:rounded-lg p-4 row justify-center gap-4">
                <div class="bg-white p-4 rounded col shadow">
                    <div class="flex justify-between mb-3">
                        <p class="text-2xl font-bold"><i class="bi bi-backpack"></i> Course</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="table table-hover table-fixed">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Code</th>
                                    <th scope="col" colspan="3">Name</th>
                                    <th scope="col">Lecturer</th>
                                    <th scope="col">Dpm</th>
                                    <th scope="col">student</th>
                                </tr>
                            </thead>
                            <tbody class="scrollable-tbody">
                                @foreach ($courses as $course)
                                    <tr>
                                        <td>{{ $course->code }}</td>
                                        <td colspan="3" data-toggle="tooltip" data-placement="top" title="{{ $course->title }}">{{ Str::limit($course->title, 20) }}</td>
                                        <td>{{ optional($course->getTeacher)->name }}</td>
                                        <td>{{ $course->getDpm->name }}</td>
                                        <td>{{ count($course->studens ?? []) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="max-w-sm w-full bg-white rounded-lg shadow  p-4 md:p-6 col">
                    <div class="flex justify-between items-start w-full">
                        <div class="flex-col items-center">
                            <h5 class="text-xl font-bold leading-none text-gray-900  mr-1"><i class="bi bi-briefcase"></i> All Course</h5>
                        </div>
                    </div>
                    <!-- Line Chart -->
                    <div class="py-6" id="pie-chart"></div>
                </div>
            </div>
        </div>
    </div>

    <hr class="w-4/5 h-0.5 mx-auto border-0 rounded bg-gray-700">

    <div class="text-center mt-5">
        <p class="fs-1 fw-bold">Roles & Permissions</p>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="sm:rounded-lg p-4 row justify-center">
                <div class="p-4 rounded-lg row">
                    <div class="col-6 ">
                        <div class="bg-white p-4 shadow rounded-lg">
                            <div class="flex justify-between mb-3">
                                <p class="text-2xl font-bold"><i class="bi bi-person-square"></i> Roles</p>
                                <button class="btn btn-success" onclick="addRole()" ><i class="bi bi-plus-lg"></i></button>
                            </div>
                            <div class="overflow-auto">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Action</th>
                                            <th scope="col">Name</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td><button class="btn btn-sm btn-danger" id="delBtn" deltype="role" value="{{ $role->name }}"><i class="bi bi-trash"></i></button></td>
                                                <td class="text-nowrap">{{$role->name}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-white p-4 shadow rounded-lg">
                            <div class="flex justify-between mb-3">
                                <p class="text-2xl font-bold"><i class="bi bi-person-fill-gear"></i> Permissions</p>
                                <button class="btn btn-success" onclick="addPerm()"><i class="bi bi-plus-lg"></i></button>
                            </div>
                            <div class="overflow-auto">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Action</th>
                                            <th scope="col">Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissions as $permission)
                                            <tr>
                                                <td><button class="btn btn-sm btn-danger" id="delBtn" deltype="perm" value="{{ $permission->name }}"><i class="bi bi-trash"></i></button></td>
                                                <td class="text-nowrap">{{$permission->name}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        $seriesList = [];
        $dpmList= [];
        foreach ($dpms as $key => $dpm) {
            $seriesList[] = App\Models\course::where('dpm', $dpm->id)->count();
            $dpmList[] = $dpm->name;
        };
    @endphp
</x-app-layout>

<script>
    // ApexCharts options and config
    window.addEventListener("load", function() {
        const seriesList = @json($seriesList); // Converts the PHP array to a JSON string that JavaScript can read
        const dpmList = @json($dpmList);

        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
        const colors = seriesList.map(() => getRandomColor());
      const getChartOptions = () => {
          return {
            series: seriesList,
            colors: colors,
            chart: {
              height: 420,
              width: "100%",
              type: "pie",
            },
            stroke: {
              colors: ["white"],
              lineCap: "",
            },
            plotOptions: {
              pie: {
                labels: {
                  show: true,
                },
                size: "100%",
                dataLabels: {
                  offset: -25
                }
              },
            },
            labels: dpmList,
            dataLabels: {
              enabled: true,
              style: {
                fontFamily: "Inter, sans-serif",
              },
            },
            legend: {
              position: "bottom",
              fontFamily: "Inter, sans-serif",
            },
            yaxis: {
              labels: {
                formatter: function (value) {
                  return value
                },
              },
            },
            xaxis: {
              labels: {
                formatter: function (value) {
                  return value
                },
              },
              axisTicks: {
                show: false,
              },
              axisBorder: {
                show: false,
              },
            },
          }
        }

        if (document.getElementById("pie-chart") && typeof ApexCharts !== 'undefined') {
          const chart = new ApexCharts(document.getElementById("pie-chart"), getChartOptions());
          chart.render();
        }
    });


    addAgn = () => {
        Swal.fire({
            title: 'Add Agency',
            html: `
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name">
                </div>
                <div class="mb-3">
                    <label for="addr" class="form-label">Address</label>
                    <input type="text" class="form-control" id="addr">
                </div>
                <div class="mb-3">
                    <label for="cont" class="form-label">Contact</label>
                    <input type="text" class="form-control" id="cont">
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: "Save",
            preConfirm: () => {
                const agnname = document.getElementById('name').value;
                const addr = document.getElementById('addr').value;
                const cont = document.getElementById('cont').value;

                if (!agnname) {
                    Swal.showValidationMessage("Name is required");
                    return;
                }

                return fetch('/manage/addAgency', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ name: agnname, address:addr, contact:cont })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText)
                    }
                    return response.json()
                })
                .catch(error => {
                    Swal.showValidationMessage(
                        `Request failed`
                    )
                })
            }
        }).then((result) => {
            if (result.isConfirmed) {
                console.log(result.value);
                Swal.fire(
                    'Saved!',
                    'Your department was saved successfully.',
                    'success'
                )
            }
        });
    }

    addBrn = () => {
        Swal.fire({
            title: 'Add Branch',
            html: `
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name">
                </div>

                <label for="agn" class="form-label">Agency</label>
                <select class="form-select" aria-label="Default select example" id="agn">
                    @foreach ($agns as $agn)
                        <option value="{{$agn->id}}">{{$agn->name}}</option>
                    @endforeach
                </select>
            `,
            showCancelButton: true,
            confirmButtonText: "Save",
            preConfirm: () => {
                const brnname = document.getElementById('name').value;
                const agn = document.getElementById('agn').value;

                if (!brnname) {
                    Swal.showValidationMessage("Name is required");
                    return;
                }

                return fetch('/manage/addBranch', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ name: brnname, agency:agn })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText)
                    }
                    return response.json()
                })
                .catch(error => {
                    Swal.showValidationMessage(
                        `Request failed`
                    )
                })
            }
        }).then((result) => {
            if (result.isConfirmed) {
                console.log(result.value);
                Swal.fire(
                    'Saved!',
                    'Your department was saved successfully.',
                    'success'
                )
            }
        });
    }

    addRole = () => {
        Swal.fire({
            title: 'Add Role',
            html: `
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name">
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: "Save",
            preConfirm: () => {
                const rname = document.getElementById('name').value;

                if (!rname) {
                    Swal.showValidationMessage("Name is required");
                    return;
                }

                return fetch('/manage/addRole', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ name: rname })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText)
                    }
                    return response.json()
                })
                .catch(error => {
                    Swal.showValidationMessage(
                        `Request failed`
                    )
                })
            }
        }).then((result) => {
            if (result.isConfirmed) {
                console.log(result.value);
                Swal.fire(
                    'Saved!',
                    'Your department was saved successfully.',
                    'success'
                )
            }
        });
    }

    addPerm = () => {
        Swal.fire({
            title: 'Add Permission',
            html: `
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name">
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: "Save",
            preConfirm: () => {
                const pname = document.getElementById('name').value;

                if (!pname) {
                    Swal.showValidationMessage("Name is required");
                    return;
                }

                return fetch('/manage/addPerm', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ name: pname })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText)
                    }
                    return response.json()
                })
                .catch(error => {
                    Swal.showValidationMessage(
                        `Request failed`
                    )
                })
            }
        }).then((result) => {
            if (result.isConfirmed) {
                console.log(result.value);
                Swal.fire(
                    'Saved!',
                    'Your department was saved successfully.',
                    'success'
                )
            }
        });
    }

    addDpm = () => {
        Swal.fire({
            title: 'Add Department',
            html: `
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name">
                </div>

                <div class="mb-3">
                    <label for="prefix" class="form-label">Prefix</label>
                    <input type="text" class="form-control" id="prefix">
                </div>

                <label for="brn" class="form-label">Branch</label>
                <select class="form-select" aria-label="Default select example" id="brn">
                    @foreach ($brns as $brn)
                        <option value="{{$brn->id}}">{{$brn->name}}</option>
                    @endforeach
                </select>
            `,
            showCancelButton: true,
            confirmButtonText: 'Save',
            showLoaderOnConfirm: true,
            preConfirm: (name) => {
                const dpmname = document.getElementById('name').value;
                const prefix = document.getElementById('prefix').value;
                const brn = document.getElementById('brn').value;

                if (!dpmname || !prefix ) {
                    Swal.showValidationMessage("Name or prefix is required");
                    return;
                }

                return fetch('/manage/addDpm', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ name: dpmname, branch:brn, prefix:prefix })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText)
                    }
                    return response.json()
                })
                .catch(error => {
                    Swal.showValidationMessage(
                        `Request failed`
                    )
                })
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                console.log(result.value);
                Swal.fire(
                    'Saved!',
                    'Your department was saved successfully.',
                    'success'
                )
            }
        })

    }


    const delBtns = document.querySelectorAll('#delBtn');
    delBtns.forEach((delbtn) => {
        delbtn.addEventListener('click', () => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    const delId = delbtn.value;
                    const delType = delbtn.getAttribute('deltype');

                    return fetch('/manage/delete', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ delid: delId, type:delType })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }
                        return response.json()
                    })
                    .catch(error => {
                        Swal.showValidationMessage(
                            `Request failed`
                        )
                    })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(result.value);
                    Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                    )
                }
            })
        })
    })

    const editBtns = document.querySelectorAll('#editBtn');
    editBtns.forEach((editbtn) => {
        const eid = editbtn.value;
        const etype = editbtn.getAttribute('edittype');

        if (etype == 'agn') {
            const ename = editbtn.getAttribute('agnName');
            const eaddr = editbtn.getAttribute('agnAddr');
            const econt = editbtn.getAttribute('agnCont');
            editbtn.addEventListener('click', () => {
                Swal.fire({
                    title: 'Edit Agency',
                    html: `
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" value="${ename}">
                        </div>
                        <div class="mb-3">
                            <label for="addr" class="form-label">Address</label>
                            <input type="text" class="form-control" id="addr" value="${eaddr}">
                        </div>
                        <div class="mb-3">
                            <label for="cont" class="form-label">Contact</label>
                            <input type="text" class="form-control" id="cont" value="${econt}">
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: "Save",
                    preConfirm: () => {
                        const agnname = document.getElementById('name').value;
                        const addr = document.getElementById('addr').value;
                        const cont = document.getElementById('cont').value;

                        if (!agnname) {
                            Swal.showValidationMessage("Name is required");
                            return;
                        }

                        return fetch('/manage/update', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ name: agnname, address:addr, contact:cont, agnid: eid, editType: etype})
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(response.statusText)
                            }
                            return response.json()
                        })
                        .catch(error => {
                            Swal.showValidationMessage(
                                `Request failed`
                            )
                        })
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log(result.value);
                        Swal.fire(
                            'Saved!',
                            'Your department was saved successfully.',
                            'success'
                        )
                    }
                });
            })
        } else if (etype == 'brn') {
            const brnName = editbtn.getAttribute('brnName');
            const brnAgn = editbtn.getAttribute('brnAgn');
            editbtn.addEventListener('click', () => {
                Swal.fire({
                    title: 'Add Branch',
                    html: `
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" value="${brnName}">
                        </div>

                        <label for="agn" class="form-label">Agency</label>
                        <select class="form-select" aria-label="Default select example" id="agn" value="${brnAgn}">
                            @foreach ($agns as $agn)
                                <option value="{{$agn->id}}">{{$agn->name}}</option>
                            @endforeach
                        </select>
                    `,
                    showCancelButton: true,
                    confirmButtonText: "Save",
                    preConfirm: () => {
                        const brnname = document.getElementById('name').value;
                        const agn = document.getElementById('agn').value;

                        if (!brnname) {
                            Swal.showValidationMessage("Name is required");
                            return;
                        }

                        return fetch('/manage/update', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ name: brnname, agency:agn,  brnid: eid, editType: etype})
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(response.statusText)
                            }
                            return response.json()
                        })
                        .catch(error => {
                            Swal.showValidationMessage(
                                `Request failed`
                            )
                        })
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log(result.value);
                        Swal.fire(
                            'Saved!',
                            'Your department was saved successfully.',
                            'success'
                        )
                    }
                });
            })
        } else if (etype == 'dpm') {
            const dpmName = editbtn.getAttribute('dpmName');
            const dpmPrefix = editbtn.getAttribute('dpmPrefix');
            const dpmBrn = editbtn.getAttribute('dpmBrn');
            editbtn.addEventListener('click', () => {
                Swal.fire({
                    title: 'Add Department',
                    html: `
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" value="${dpmName}">
                        </div>

                        <div class="mb-3">
                            <label for="prefix" class="form-label">Prefix</label>
                            <input type="text" class="form-control" id="prefix" value="${dpmPrefix}">
                        </div>

                        <label for="brn" class="form-label">Branch</label>
                        <select class="form-select" aria-label="Default select example" id="brn" value="${dpmBrn}">
                            @foreach ($brns as $brn)
                                <option value="{{$brn->id}}">{{$brn->name}}</option>
                            @endforeach
                        </select>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    showLoaderOnConfirm: true,
                    preConfirm: (name) => {
                        const dpmname = document.getElementById('name').value;
                        const prefix = document.getElementById('prefix').value;
                        const brn = document.getElementById('brn').value;

                        if (!dpmname || !prefix ) {
                            Swal.showValidationMessage("Name or prefix is required");
                            return;
                        }

                        return fetch('/manage/update', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ name: dpmname, branch:brn, prefix:prefix, dpmid: eid, editType: etype })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(response.statusText)
                            }
                            return response.json()
                        })
                        .catch(error => {
                            Swal.showValidationMessage(
                                `Request failed`
                            )
                        })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log(result.value);
                        Swal.fire(
                            'Saved!',
                            'Your department was saved successfully.',
                            'success'
                        )
                    }
                });
            })
        }

    })
</script>

<style>
.table-fixed tbody {
        height: calc(6 * 50px); /* Assuming each row is 50px high */
        overflow-y: auto;
        display: block;
    }

    .table-fixed thead,
    .table-fixed tbody tr {
        display: table;
        width: 100%; /* Optional for width:table-layout fixed */
        table-layout: fixed; /* Optional: Helps in equal width of cols */
    }

    .table-fixed thead {
        width: calc(100% - 1em); /* Adjust this value if a scrollbar appears */
        background: #000; /* Keeping the header style consistent */
    }

    .table-hover tbody tr:hover {
        background-color: #f5f5f5; /* or any hover color */
    }
</style>
