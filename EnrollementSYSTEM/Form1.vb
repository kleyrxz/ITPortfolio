Imports System.Data.SqlClient
Public Class Form1

    Private Sub Form1_KeyPress(sender As System.Object, e As System.Windows.Forms.KeyPressEventArgs) Handles MyBase.KeyPress, ComboStat.KeyPress, ComboSem.KeyPress, comboGender.KeyPress, comboCs.KeyPress
        e.Handled = True
    End Sub

    Private Sub Form1_Load(sender As System.Object, e As System.EventArgs) Handles MyBase.Load
        ComboSem.Items.Add("")

        ComboSem.Items.Add("First Semester")
        ComboSem.Items.Add("Second Semester")

        ComboStat.Items.Add("")

        ComboStat.Items.Add("Regular")
        ComboStat.Items.Add("Transferee")

        comboGender.Items.Add("")

        comboGender.Items.Add("Female")
        comboGender.Items.Add("Male")

        comboCs.Items.Add("")

        comboCs.Items.Add("Single")
        comboCs.Items.Add("Married")

        comboYl.Items.Add("")

        comboYl.Items.Add("1st Year")
        comboYl.Items.Add("2nd Year")
        comboYl.Items.Add("3rd Year")
        comboYl.Items.Add("4th Year")


        BindData()


        
    End Sub

    Private Sub btnSelect_Click(sender As System.Object, e As System.EventArgs) Handles btnSelect.Click

        Dim Gradelev As String = comboYl.Text
        Dim Sem As String = ComboSem.Text
        Dim Dt As String = txtDate.Text
        Dim Lrn As String = txtLrn.Text
        Dim SY As String = txtSY.Text
        Dim Stat As String = ComboStat.Text
        Dim LName As String = txtLname.Text
        Dim FName As String = txtFname.Text
        Dim MName As String = txtMname.Text
        Dim Gender As String = comboGender.Text
        Dim DoB As String = txtDoB.Text
        Dim CivilStat As String = comboCs.Text
        Dim CitizenS As String = txtCits.Text
        Dim Relig As String = txtReligion.Text
        Dim SUnit As String = txtSunit.Text
        Dim Street As String = txtStreet.Text
        Dim Subdi As String = txtSub.Text
        Dim Brgy As String = txtBrgy.Text
        Dim City As String = txtCity.Text
        Dim Zc As String = txtZip.Text
        Dim ContactNum As String = txtContactnum.Text
        Dim EmailAdd As String = txtEA.Text
        Dim Fb As String = txtfb.Text
        Dim FatherN As String = txtFatherN.Text
        Dim Cel1 As String = txtCn.Text
        Dim MotherN As String = txtMotherN.Text
        Dim Cel2 As String = txtCn2.Text
        Dim GuardN As String = txtGN.Text
        Dim Cel3 As String = txtCn3.Text
        Dim LastSchool As String = txtLastschool.Text


        Dim query As String = "Insert into TB_Enrollees1 values (@GradeLevel, @Semester, @Date, @Lrn, @SchoolYear, @Status, @LastName, @FirstName, @MiddleName, @Gender, @DateofBirth, @CivilStatus, @Citizenship, @Religion, @StreetUnit, @Street, @Subdivision, @Barangay, @City, @ZipCode, @ContactNum, @Emailadd, @Fb, @FatherName, @Celno1, @MotherName, @Celno2, @GuardianName, @Celno3, @LastSchool)"
        Using con As SqlConnection = New SqlConnection("Data Source=DESKTOP-O91ELP8\SQLEXPRESS;Initial Catalog=EnrollmentSYSTEM1;Integrated Security=True;Pooling=False")
            Using cmd As SqlCommand = New SqlCommand(query, con)
                cmd.Parameters.AddWithValue("@GradeLevel", Gradelev)
                cmd.Parameters.AddWithValue("@Semester", Sem)
                cmd.Parameters.AddWithValue("@Date", Dt)
                cmd.Parameters.AddWithValue("@Lrn", Lrn)
                cmd.Parameters.AddWithValue("@SchoolYear", SY)
                cmd.Parameters.AddWithValue("@Status", Stat)
                cmd.Parameters.AddWithValue("@LastName", LName)
                cmd.Parameters.AddWithValue("@FirstName", FName)
                cmd.Parameters.AddWithValue("@MiddleName", MName)
                cmd.Parameters.AddWithValue("@Gender", Gender)
                cmd.Parameters.AddWithValue("@DateofBirth", DoB)
                cmd.Parameters.AddWithValue("@CivilStatus", CivilStat)
                cmd.Parameters.AddWithValue("@Citizenship", CitizenS)
                cmd.Parameters.AddWithValue("@Religion", Relig)
                cmd.Parameters.AddWithValue("@StreetUnit", SUnit)
                cmd.Parameters.AddWithValue("@Street", Street)
                cmd.Parameters.AddWithValue("@Subdivision", Subdi)
                cmd.Parameters.AddWithValue("@Barangay", Brgy)
                cmd.Parameters.AddWithValue("@City", City)
                cmd.Parameters.AddWithValue("@ZipCode", Zc)
                cmd.Parameters.AddWithValue("@ContactNum", ContactNum)
                cmd.Parameters.AddWithValue("@Emailadd", EmailAdd)
                cmd.Parameters.AddWithValue("@Fb", Fb)
                cmd.Parameters.AddWithValue("@FatherName", FatherN)
                cmd.Parameters.AddWithValue("@Celno1", Cel1)
                cmd.Parameters.AddWithValue("@MotherName", MotherN)
                cmd.Parameters.AddWithValue("@Celno2", Cel2)
                cmd.Parameters.AddWithValue("@GuardianName", GuardN)
                cmd.Parameters.AddWithValue("@Celno3", Cel3)
                cmd.Parameters.AddWithValue("@LastSchool", LastSchool)
                con.Open()
                cmd.ExecuteNonQuery()
                con.Close()
                MessageBox.Show("Succesfully Added")
                BindData()


            End Using
        End Using

        clear()
    End Sub

    Private Sub txtLrn_KeyPress(sender As System.Object, e As System.Windows.Forms.KeyPressEventArgs) Handles txtLrn.KeyPress
        If Not Char.IsNumber(e.KeyChar) AndAlso Not Char.IsControl(e.KeyChar) Then
            e.Handled = True
        End If
    End Sub

   
    Private Sub txtZip_KeyPress(sender As System.Object, e As System.Windows.Forms.KeyPressEventArgs) Handles txtZip.KeyPress
        If Not Char.IsNumber(e.KeyChar) AndAlso Not Char.IsControl(e.KeyChar) Then
            e.Handled = True
        End If
    End Sub

    Private Sub txtCn_KeyPress(sender As System.Object, e As System.Windows.Forms.KeyPressEventArgs) Handles txtCn.KeyPress
        If Not Char.IsNumber(e.KeyChar) AndAlso Not Char.IsControl(e.KeyChar) Then
            e.Handled = True
        End If
    End Sub

    Private Sub txtCn2_KeyPress(sender As System.Object, e As System.Windows.Forms.KeyPressEventArgs) Handles txtCn2.KeyPress
        If Not Char.IsNumber(e.KeyChar) AndAlso Not Char.IsControl(e.KeyChar) Then
            e.Handled = True
        End If
    End Sub

   
    Private Sub txtCn3_KeyPress(sender As System.Object, e As System.Windows.Forms.KeyPressEventArgs) Handles txtCn3.KeyPress
        If Not Char.IsNumber(e.KeyChar) AndAlso Not Char.IsControl(e.KeyChar) Then
            e.Handled = True
        End If
    End Sub

    Private Sub txtContactnum_KeyPress(sender As System.Object, e As System.Windows.Forms.KeyPressEventArgs) Handles txtContactnum.KeyPress
        If Not Char.IsNumber(e.KeyChar) AndAlso Not Char.IsControl(e.KeyChar) Then
            e.Handled = True
        End If
    End Sub

    Private Sub BindData()

        Dim query As String = " select * from TB_Enrollees1 "
        Using con As SqlConnection = New SqlConnection("Data Source=DESKTOP-O91ELP8\SQLEXPRESS;Initial Catalog=EnrollmentSYSTEM1;Integrated Security=True;Pooling=False")
            Using cmd As SqlCommand = New SqlCommand(query, con)
                Using da As New SqlDataAdapter()
                    da.SelectCommand = cmd
                    Using dt As New DataTable()
                        da.Fill(dt)
                        DataGridView1().DataSource() = dt
                    End Using


                End Using
            End Using
        End Using
    End Sub

    Private Sub btnGet_Click(sender As System.Object, e As System.EventArgs) Handles btnGet.Click
        Dim id As String = txtID.Text
        Dim query As String = "SELECT * FROM TB_Enrollees1 WHERE id = @id"
        Using con As SqlConnection = New SqlConnection("Data Source=DESKTOP-O91ELP8\SQLEXPRESS;Initial Catalog=EnrollmentSYSTEM1;Integrated Security=True;Pooling=False")
            Using cmd As SqlCommand = New SqlCommand(query, con)
                cmd.Parameters.AddWithValue("@id", id)
                Using da As New SqlDataAdapter()
                    da.SelectCommand = cmd

                    Using dt As New DataTable()
                        da.Fill(dt)

                        If dt.Rows.Count > 0 Then

                            comboYl.Text = dt.Rows(0)(1).ToString
                            ComboSem.Text = dt.Rows(0)(2).ToString
                            txtDate.Text = dt.Rows(0)(3).ToString
                            txtLrn.Text = dt.Rows(0)(4).ToString
                            txtSY.Text = dt.Rows(0)(5).ToString
                            ComboStat.Text = dt.Rows(0)(6).ToString
                            txtLname.Text = dt.Rows(0)(7).ToString
                            txtFname.Text = dt.Rows(0)(8).ToString
                            txtMname.Text = dt.Rows(0)(9).ToString
                            comboGender.Text = dt.Rows(0)(10).ToString
                            txtDoB.Text = dt.Rows(0)(11).ToString
                            comboCs.Text = dt.Rows(0)(12).ToString
                            txtCits.Text = dt.Rows(0)(13).ToString
                            txtReligion.Text = dt.Rows(0)(14).ToString
                            txtSunit.Text = dt.Rows(0)(15).ToString
                            txtStreet.Text = dt.Rows(0)(16).ToString
                            txtSub.Text = dt.Rows(0)(17).ToString
                            txtBrgy.Text = dt.Rows(0)(18).ToString
                            txtCity.Text = dt.Rows(0)(19).ToString
                            txtZip.Text = dt.Rows(0)(20).ToString
                            txtContactnum.Text = dt.Rows(0)(21).ToString
                            txtEA.Text = dt.Rows(0)(22).ToString
                            txtfb.Text = dt.Rows(0)(23).ToString
                            txtFatherN.Text = dt.Rows(0)(24).ToString
                            txtCn.Text = dt.Rows(0)(25).ToString
                            txtMotherN.Text = dt.Rows(0)(26).ToString
                            txtCn2.Text = dt.Rows(0)(27).ToString
                            txtGN.Text = dt.Rows(0)(28).ToString
                            txtCn3.Text = dt.Rows(0)(29).ToString
                            txtLastschool.Text = dt.Rows(0)(30).ToString

                        Else
                            MsgBox("No Data Found")

                        End If

                    End Using

                End Using
            End Using
        End Using
    End Sub

    Private Sub clear()

        comboYl.Text = ""
        ComboSem.Text = ""
        txtDate.Text = ""
        txtLrn.Text = ""
        txtSY.Text = ""
        ComboStat.Text = ""
        txtLname.Text = ""
        txtFname.Text = ""
        txtMname.Text = ""
        comboGender.Text = ""
        txtDoB.Text = ""
        comboCs.Text = ""
        txtCits.Text = ""
        txtReligion.Text = ""
        txtSunit.Text = ""
        txtStreet.Text = ""
        txtSub.Text = ""
        txtBrgy.Text = ""
        txtCity.Text = ""
        txtZip.Text = ""
        txtContactnum.Text = ""
        txtEA.Text = ""
        txtfb.Text = ""
        txtFatherN.Text = ""
        txtCn.Text = ""
        txtMotherN.Text = ""
        txtCn2.Text = ""
        txtGN.Text = ""
        txtCn3.Text = ""
        txtLastschool.Text = ""

    End Sub

    Private Sub btnUpdate_Click(sender As System.Object, e As System.EventArgs) Handles btnUpdate.Click

        Dim ID As String = txtID.Text
        Dim Gradelev As String = comboYl.Text
        Dim Sem As String = ComboSem.Text
        Dim Dt As String = txtDate.Text
        Dim Lrn As String = txtLrn.Text
        Dim SY As String = txtSY.Text
        Dim Stat As String = ComboStat.Text
        Dim LName As String = txtLname.Text
        Dim FName As String = txtFname.Text
        Dim MName As String = txtMname.Text
        Dim Gender As String = comboGender.Text
        Dim DoB As String = txtDoB.Text
        Dim CivilStat As String = comboCs.Text
        Dim CitizenS As String = txtCits.Text
        Dim Relig As String = txtReligion.Text
        Dim SUnit As String = txtSunit.Text
        Dim Street As String = txtStreet.Text
        Dim Subdi As String = txtSub.Text
        Dim Brgy As String = txtBrgy.Text
        Dim City As String = txtCity.Text
        Dim Zc As String = txtZip.Text
        Dim ContactNum As String = txtContactnum.Text
        Dim EmailAdd As String = txtEA.Text
        Dim Fb As String = txtfb.Text
        Dim FatherN As String = txtFatherN.Text
        Dim Cel1 As String = txtCn.Text
        Dim MotherN As String = txtMotherN.Text
        Dim Cel2 As String = txtCn2.Text
        Dim GuardN As String = txtGN.Text
        Dim Cel3 As String = txtCn3.Text
        Dim LastSchool As String = txtLastschool.Text


        Dim query As String = "Update TB_Enrollees1 Set GradeLevel = @GradeLevel, Semester = @Semester, Date = @Date, Lrn = @Lrn, SchoolYear = @SchoolYear, Status = @Status, LastName = @LastName, FirstName = @FirstName, MiddleName = @MiddleName, Gender = @Gender, DateofBirth = @DateofBirth, CivilStatus = @CivilStatus, Citizenship = @Citizenship, StreetUnit = @StreetUnit, Street = @Street, Subdivision = @Subdivision, Barangay = @Barangay, City = @City, ZipCode = @ZipCode, ContactNum = @ContactNum, Emailadd = @Emailadd, Fb = @Fb, FatherName = @FatherName, Celno1 = @Celno1, MotherName = @MotherName, Celno2 = @Celno2, GuardianName = @GuardianName, Celno3 = @Celno3, LastSchool = @LastSchool Where ID = @ID"
        Using con As SqlConnection = New SqlConnection("Data Source=DESKTOP-O91ELP8\SQLEXPRESS;Initial Catalog=EnrollmentSYSTEM1;Integrated Security=True;Pooling=False")
            Using cmd As SqlCommand = New SqlCommand(query, con)
                cmd.Parameters.AddWithValue("@GradeLevel", Gradelev)
                cmd.Parameters.AddWithValue("@Semester", Sem)
                cmd.Parameters.AddWithValue("@Date", Dt)
                cmd.Parameters.AddWithValue("@Lrn", Lrn)
                cmd.Parameters.AddWithValue("@SchoolYear", SY)
                cmd.Parameters.AddWithValue("@Status", Stat)
                cmd.Parameters.AddWithValue("@LastName", LName)
                cmd.Parameters.AddWithValue("@FirstName", FName)
                cmd.Parameters.AddWithValue("@MiddleName", MName)
                cmd.Parameters.AddWithValue("@Gender", Gender)
                cmd.Parameters.AddWithValue("@DateofBirth", DoB)
                cmd.Parameters.AddWithValue("@CivilStatus", CivilStat)
                cmd.Parameters.AddWithValue("@Citizenship", CitizenS)
                cmd.Parameters.AddWithValue("@Religion", Relig)
                cmd.Parameters.AddWithValue("@StreetUnit", SUnit)
                cmd.Parameters.AddWithValue("@Street", Street)
                cmd.Parameters.AddWithValue("@Subdivision", Subdi)
                cmd.Parameters.AddWithValue("@Barangay", Brgy)
                cmd.Parameters.AddWithValue("@City", City)
                cmd.Parameters.AddWithValue("@ZipCode", Zc)
                cmd.Parameters.AddWithValue("@ContactNum", ContactNum)
                cmd.Parameters.AddWithValue("@Emailadd", EmailAdd)
                cmd.Parameters.AddWithValue("@Fb", Fb)
                cmd.Parameters.AddWithValue("@FatherName", FatherN)
                cmd.Parameters.AddWithValue("@Celno1", Cel1)
                cmd.Parameters.AddWithValue("@MotherName", MotherN)
                cmd.Parameters.AddWithValue("@Celno2", Cel2)
                cmd.Parameters.AddWithValue("@GuardianName", GuardN)
                cmd.Parameters.AddWithValue("@Celno3", Cel3)
                cmd.Parameters.AddWithValue("@LastSchool", LastSchool)
                cmd.Parameters.AddWithValue("@ID", ID)
                con.Open()
                cmd.ExecuteNonQuery()
                con.Close()
                MessageBox.Show("Succesfully Updated")
                BindData()

                comboYl.Text = ""
                ComboSem.Text = ""
                txtDate.Text = ""
                txtLrn.Text = ""
                txtSY.Text = ""
                ComboStat.Text = ""
                txtLname.Text = ""
                txtFname.Text = ""
                txtMname.Text = ""
                comboGender.Text = ""
                txtDoB.Text = ""
                comboCs.Text = ""
                txtCits.Text = ""
                txtReligion.Text = ""
                txtSunit.Text = ""
                txtStreet.Text = ""
                txtSub.Text = ""
                txtBrgy.Text = ""
                txtCity.Text = ""
                txtZip.Text = ""
                txtContactnum.Text = ""
                txtEA.Text = ""
                txtfb.Text = ""
                txtFatherN.Text = ""
                txtCn.Text = ""
                txtMotherN.Text = ""
                txtCn2.Text = ""
                txtGN.Text = ""
                txtCn3.Text = ""
                txtLastschool.Text = ""


            End Using
        End Using

        clear()
    End Sub

    Private Sub btnDelete_Click(sender As System.Object, e As System.EventArgs) Handles btnDelete.Click

        Dim ID As String = txtID.Text
       
        Dim query As String = "delete TB_Enrollees1 where ID = @ID"
        Using con As SqlConnection = New SqlConnection("Data Source=DESKTOP-O91ELP8\SQLEXPRESS;Initial Catalog=EnrollmentSYSTEM1;Integrated Security=True;Pooling=False")
            Using cmd As SqlCommand = New SqlCommand(query, con)
                
                cmd.Parameters.AddWithValue("@ID", ID)
                con.Open()
                cmd.ExecuteNonQuery()
                con.Close()
                MessageBox.Show("Succesfully Deleted")
                BindData()

            End Using
        End Using

    End Sub

    
    Private Sub Rad1st_CheckedChanged(sender As System.Object, e As System.EventArgs) Handles Rad1st.CheckedChanged
        If Rad1st.Checked = True Then
            Dim query As String = "  select  * from TB_Enrollees1 where Gradelevel = '1st Year' "
            Using con As SqlConnection = New SqlConnection("Data Source=DESKTOP-O91ELP8\SQLEXPRESS;Initial Catalog=EnrollmentSYSTEM1;Integrated Security=True;Pooling=False")
                Using cmd As SqlCommand = New SqlCommand(query, con)
                    Using da As New SqlDataAdapter()
                        da.SelectCommand = cmd
                        Using dt As New DataTable()
                            da.Fill(dt)

                            If dt.Rows.Count > 0 Then
                                DataGridView1().DataSource() = dt
                            Else
                                MsgBox("No Data Found")

                            End If



                        End Using


                    End Using
                End Using
            End Using

        End If
    End Sub

    Private Sub Rad2nd_CheckedChanged(sender As System.Object, e As System.EventArgs) Handles Rad2nd.CheckedChanged
        If Rad2nd.Checked = True Then
            Dim query As String = "  select  * from TB_Enrollees1 where Gradelevel = '2nd Year' "
            Using con As SqlConnection = New SqlConnection("Data Source=DESKTOP-O91ELP8\SQLEXPRESS;Initial Catalog=EnrollmentSYSTEM1;Integrated Security=True;Pooling=False")
                Using cmd As SqlCommand = New SqlCommand(query, con)
                    Using da As New SqlDataAdapter()
                        da.SelectCommand = cmd
                        Using dt As New DataTable()
                            da.Fill(dt)

                            If dt.Rows.Count > 0 Then
                                DataGridView1().DataSource() = dt
                            Else
                                MsgBox("No Data Found")

                            End If



                        End Using


                    End Using
                End Using
            End Using

        End If
    End Sub

    Private Sub Rad3rd_CheckedChanged(sender As System.Object, e As System.EventArgs) Handles Rad3rd.CheckedChanged
        If Rad3rd.Checked = True Then
            Dim query As String = "  select  * from TB_Enrollees1 where Gradelevel = '3rd Year' "
            Using con As SqlConnection = New SqlConnection("Data Source=DESKTOP-O91ELP8\SQLEXPRESS;Initial Catalog=EnrollmentSYSTEM1;Integrated Security=True;Pooling=False")
                Using cmd As SqlCommand = New SqlCommand(query, con)
                    Using da As New SqlDataAdapter()
                        da.SelectCommand = cmd
                        Using dt As New DataTable()
                            da.Fill(dt)

                            If dt.Rows.Count > 0 Then
                                DataGridView1().DataSource() = dt
                            Else
                                MsgBox("No Data Found")

                            End If



                        End Using


                    End Using
                End Using
            End Using

        End If
    End Sub

    Private Sub Rad4th_CheckedChanged(sender As System.Object, e As System.EventArgs) Handles Rad4th.CheckedChanged
        If Rad4th.Checked = True Then
            Dim query As String = "  select  * from TB_Enrollees1 where Gradelevel = '4th Year' "
            Using con As SqlConnection = New SqlConnection("Data Source=DESKTOP-O91ELP8\SQLEXPRESS;Initial Catalog=EnrollmentSYSTEM1;Integrated Security=True;Pooling=False")
                Using cmd As SqlCommand = New SqlCommand(query, con)
                    Using da As New SqlDataAdapter()
                        da.SelectCommand = cmd
                        Using dt As New DataTable()
                            da.Fill(dt)

                            If dt.Rows.Count > 0 Then
                                DataGridView1().DataSource() = dt
                            Else
                                MsgBox("No Data Found")

                            End If



                        End Using


                    End Using
                End Using
            End Using

        End If
    End Sub




   

End Class
