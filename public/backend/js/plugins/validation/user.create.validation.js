$(document).ready(function () {
    $('#userCreate').bootstrapValidator({
        live: 'enabled',
        message: 'This value is not valid',
        submitButtons: 'button[type="submit"]',
        feedbackIcons: {
            valid: 'fa fa-check',
            invalid: 'fa fa-times',
            validating: 'fa fa-refresh'
        },
        fields: {
            login_id: {
                validators: {
                    digits: {
                        message: 'Login Id contains digits only'
                    },
                    stringLength: {
                        min: 12,
                        max: 12,
                        message: 'Login Id must be twelve digits only'
                    },
                    notEmpty: {
                        message: 'Login Id is required '
                    }
                }
            },
            email: {
                message: 'Email is not valid',
                validators: {
                    notEmpty: {
                        message: 'Email is required '
                    },
                    emailAddress: {
                        message: 'This is not a valid email address'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'Password is required '
                    },
                }
            },
            password_confirmation: {
                validators: {
                    notEmpty: {
                        message: 'Password Confirmation is required '
                    },
                    identical: {
                        field: 'password',
                        message: 'Passwords are not same'
                    }
                }
            },
            first_name: {
                message: 'Person First Name is not valid',
                validators: {
                    notEmpty: {
                        message: 'Person First Name is required '
                    },
                    regexp: {
                        regexp: /^[a-zA-Z ]*$/,
                        message: 'Person First Name can only consist of alphabetical and space'
                    },
                }
            },

            last_name: {
                message: 'Person Last Name is not valid',
                validators: {
                    notEmpty: {
                        message: 'Person Last Name is required '
                    },
                    regexp: {
                        regexp: /^[a-zA-Z ]*$/,
                        message: 'Person Last Name can only consist of alphabetical and space'
                    }
                }
            },

            mother_name: {
                message: 'Mother Name is not valid',
                validators: {
                    notEmpty: {
                        message: 'Mother Name is required '
                    },
                    regexp: {
                        regexp: /^[a-zA-Z ]*$/,
                        message: 'Mother Name can only consist of alphabetical and space'
                    }
                }
            },

            father_name: {
                message: 'Father Name is not valid',
                validators: {
                    notEmpty: {
                        message: 'Father Name is required '
                    },
                    regexp: {
                        regexp: /^[a-zA-Z ]*$/,
                        message: 'Father Name can only consist of alphabetical and space'
                    }
                }
            },

            date_of_birth: {
                validators: {
                    notEmpty: {
                        message: 'The date is required and cannot be empty'
                    },
                    date: {
                        format: 'YYYY-MM-DD'
                    }
                }
            },

            nationality: {
                message: 'Nationality is not valid',
                validators: {
                    regexp: {
                        regexp: /^[a-zA-Z ]*$/,
                        message: 'Nationality can only consist of alphabetical and space'
                    },
                }
            },

            profession: {
                message: 'Profession is not valid',
                validators: {
                    regexp: {
                        regexp: /^[a-zA-Z ]*$/,
                        message: 'Profession can only consist of alphabetical and space'
                    },
                }
            },
            address: {
                validators: {
                    notEmpty: {
                        message: 'Address is required '
                    },
                    regexp: {
                        regexp: /^[a-z|A-Z|0-9|_|,| |-]*$/,
                        message: 'Address can only consist of alphabetical, digits, comma and some special character '
                    },
                },
            },

            city: {
                validators: {
                    notEmpty: {
                        message: 'City is required '
                    },
                    regexp: {
                        regexp: /^[a-z|A-Z| |]*$/,
                        message: 'City can only consist of alphabetical and space'
                    }
                }
            },


            state: {
                validators: {
                    notEmpty: {
                        message: 'State is required '
                    },
                    regexp: {
                        regexp: /^[a-z|A-Z| |]*$/,
                        message: 'State can only consist of alphabetical and space'
                    }
                }
            },
            pincode: {
                validators: {
                    digits: {
                        message: 'Pincode contains digits only'
                    },
                    stringLength: {
                        min: 6,
                        max: 6,
                        message: 'Pincode must be six digits only'
                    }
                }
            },
            std_code: {
                message: 'STD Code is not valid',
                validators: {
                    digits: {
                        message: 'STD Code contains digits only'
                    }
                }
            },

            landline: {
                message: 'LandLine Number is not valid',
                validators: {
                    digits: {
                        message: 'Land Line Number contains digits only'
                    }
                }
            },

            //mobile: {
            //    message: 'Mobile number is not valid',
            //    validators: {
            //        notEmpty: {
            //            message: 'Mobile Number is required '
            //        },
            //        digits: {
            //            message: 'Mobile number contains digits only'
            //        },
            //        stringLength: {
            //            min: 10,
            //            max: 10,
            //            message: 'Mobile number must be ten digits'
            //        }
            //    }
            //},

            pan: {
                message: 'PAN number is not valid',
                validators: {
                    regexp: {
                        regexp: /^[a-z|A-Z|0-9]*$/,
                        message: 'PAN number can only consist of alphabetical and digits'
                    },
                    stringLength: {
                        min: 10,
                        max: 10,
                        message: 'PAN number must be ten characters'
                    }
                }
            },


            nominee_name: {
                validators: {
                    regexp: {
                        regexp: /^[a-zA-Z ]*$/,
                        message: 'Nominee name can only consist of alphabet and space'
                    },
                }
            },
            //nominee_dob: {
            //    validators: {
            //        notEmpty: {
            //            message: 'The date is required and cannot be empty'
            //        },
            //        date: {
            //            format: 'YYYY-MM-DD'
            //        }
            //    }
            //},

            nominee_relation: {
                validators: {
                    regexp: {
                        regexp: /^[a-zA-Z ]*$/,
                        message: 'Nominee relative can only consist of alphabet and space'
                    },
                }
            },

            // parent_id:{
            //     message: 'Parent Id is not valid',
            //     validators:{
            //         notEmpty:{
            //             message: 'Parent Id is required '
            //         },
            //         remote:{
            //             message:'This is not a valid Parent',
            //             url: 'parent',
            //             // name:'parent_id',
            //             // data: function(validator){
            //             //     return{
            //             //         parent_id: validator.getFieldElements('parent_id').val()
            //             //     };
            //             // }
            //         }
            //     },
            // },
            //sponsor_id
            amount: {
                validators: {
                    digits: {
                        message: 'Amount contains digits only'
                    },
                    notEmpty: {
                        message: 'Amount is required '
                    }
                }
            },
            dd_no: {
                validators: {
                    digits: {
                        message: 'DD No contains digits only'
                    },
                    notEmpty: {
                        message: 'DD No is required '
                    }
                }
            },
            //dd_date: {
            //    validators: {
            //        notEmpty: {
            //            message: 'The date is required and cannot be empty'
            //        },
            //        date: {
            //            format: 'YYYY-MM-DD'
            //        }
            //    }
            //},
            //dd_drwan_date: {
            //    validators: {
            //        notEmpty: {
            //            message: 'The date is required and cannot be empty'
            //        },
            //        date: {
            //            format: 'YYYY-MM-DD'
            //        }
            //    }
            //},
            //insured_person: {
            //    validators: {
            //        notEmpty: {
            //            message: 'Insured Person is required '
            //        },
            //        regexp: {
            //            regexp: /^[a-zA-Z ]*$/,
            //            message: 'Insured Person can only consist of alphabet and space'
            //        },
            //    }
            //}
        }
    });
});

