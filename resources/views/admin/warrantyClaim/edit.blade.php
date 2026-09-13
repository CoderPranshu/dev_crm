<form action="{{ route('admin.warranty.claim.status.update', $claim->id) }}"
                                                method="POST">
                                                @csrf

                                                <select name="status" class="form-select form-select-sm"
                                                    onchange="this.form.submit()">

                                                    <option value="pending"
                                                        {{ $claim->status == 'pending' ? 'selected' : '' }}>
                                                        Pending
                                                    </option>

                                                    <option value="approved"
                                                        {{ $claim->status == 'approved' ? 'selected' : '' }}>
                                                        Approved
                                                    </option>

                                                    <option value="rejected"
                                                        {{ $claim->status == 'rejected' ? 'selected' : '' }}>
                                                        Rejected
                                                    </option>

                                                </select>

                                            </form>
