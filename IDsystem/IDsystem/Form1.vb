Imports System.Windows.Forms
Imports System.IO
Imports MessagingToolkit.QRCode.Codec
Imports MessagingToolkit.QRCode.Codec.Data
Imports System.Data.SqlClient


Public Class Form1

    Public connection As String = "Data Source=DESKTOP-O91ELP8\SQLEXPRESS;Initial Catalog=Idsystem;Integrated Security=True;Pooling=False"
    Dim qrlocation As String
    Dim qrid As String
    Dim Delete As DialogResult

    Private Sub autoclear()
        txtIdno.Text = ""
        ComboCourse.Text = ""
        txtFullname.Text = ""
        txtGuardName.Text = ""
        txtAddress.Text = ""
        txtcpno.Text = ""

        imgsignature.Image = My.Resources.signature
        Imgprofile.Image = My.Resources.image_removebg_preview__74_
        imgqr.Image = Nothing

    End Sub

    Private Sub ComboCourse_KeyPress(sender As System.Object, e As System.Windows.Forms.KeyPressEventArgs) Handles ComboCourse.KeyPress
        e.Handled = True
    End Sub


    Private Sub txtIdno_KeyPress(sender As System.Object, e As System.Windows.Forms.KeyPressEventArgs) Handles txtIdno.KeyPress
        If Not Char.IsNumber(e.KeyChar) AndAlso Not Char.IsControl(e.KeyChar) Then
            e.Handled = True
        End If
    End Sub
    Private Sub Form1_Load(sender As System.Object, e As System.EventArgs) Handles MyBase.Load
        binddata()

        btnupdate.Enabled = False
        btnDelete.Enabled = False

        ComboCourse.Items.Add("BSIT")
        ComboCourse.Items.Add("BSOA")
        ComboCourse.Items.Add("BSHM")
        ComboCourse.Items.Add("BSTM")

    End Sub

    Private Sub binddata()

        Dim query As String = "SELECT * FROM studentid"
        Using con As SqlConnection = New SqlConnection(connection)
            Using cmd As SqlCommand = New SqlCommand(query, con)
                Using da As New SqlDataAdapter()
                    da.SelectCommand = cmd
                    Using dt As New DataTable()
                        da.Fill(dt)
                        If dt.Rows.Count > 0 Then
                            DataGridView1.DataSource = dt
                        Else

                        End If
                    End Using
                End Using
            End Using
        End Using
    End Sub


    Private Sub Button3_Click(sender As System.Object, e As System.EventArgs) Handles Button3.Click
        Try
            With OpenFileDialog1
                .Filter = "images Files|*.png;*.jpeg;*.jpg"
                .FilterIndex = 1
            End With
            OpenFileDialog1.FileName = ""
            If OpenFileDialog1.ShowDialog = Windows.Forms.DialogResult.OK Then
                Imgprofile.ImageLocation = OpenFileDialog1.FileName
            End If
        Catch ex As Exception

        End Try
    End Sub

    Private Sub Button5_Click(sender As System.Object, e As System.EventArgs) Handles Button5.Click
        Imgprofile.Image = My.Resources.image_removebg_preview__74_
    End Sub

    Private Sub Button2_Click(sender As System.Object, e As System.EventArgs) Handles Button2.Click

        Try
            With OpenFileDialog1
                .Filter = "images Files|*.png;*.jpeg;*.jpg"
                .FilterIndex = 1
            End With
            OpenFileDialog1.FileName = ""
            If OpenFileDialog1.ShowDialog = Windows.Forms.DialogResult.OK Then
                imgsignature.ImageLocation = OpenFileDialog1.FileName
            End If
        Catch ex As Exception

        End Try

    End Sub

    Private Sub Button6_Click(sender As System.Object, e As System.EventArgs) Handles Button6.Click
        imgsignature.Image = My.Resources.signature
    End Sub

    Private Sub btnAdd_Click(sender As System.Object, e As System.EventArgs) Handles btnAdd.Click

        If txtIdno.Text.Length > 0 Or ComboCourse.Text.Length > 0 Or txtFullname.Text.Length > 0 Or txtGuardName.Text.Length > 0 Or txtAddress.Text.Length > 0 Or txtcpno.Text.Length > 0 Then

            Call add()
            Call createqr()
            Call saveQr()
            Call autoclear()
            Call binddata()
          
        Else

            MsgBox("Fill all the fields!", MsgBoxStyle.Exclamation)

        End If



    End Sub

    Private Sub add()
        Dim IDno As String = txtIdno.Text
        Dim Course As String = ComboCourse.Text
        Dim Fullname As String = txtFullname.Text
        Dim GName As String = txtGuardName.Text
        Dim Add As String = txtAddress.Text
        Dim Cpno As String = txtcpno.Text

        Dim query As String = "Insert into Studentid values (@IDNo, @Course, @Fname, @Gname, @Address, @Cpno, @Profilepic, @Signature, Null)"
        Using con As SqlConnection = New SqlConnection(connection)
            Using cmd As SqlCommand = New SqlCommand(query, con)
                cmd.Parameters.AddWithValue("@IDNo", IDno)
                cmd.Parameters.AddWithValue("@Course", Course)
                cmd.Parameters.AddWithValue("@Fname", Fullname)
                cmd.Parameters.AddWithValue("@Gname", GName)
                cmd.Parameters.AddWithValue("@Address", Add)
                cmd.Parameters.AddWithValue("@Cpno", Cpno)

                Dim profile As New MemoryStream
                Imgprofile.Image.Save(profile, Imgprofile.Image.RawFormat)
                cmd.Parameters.AddWithValue("@Profilepic", profile.ToArray)

                Dim signa As New MemoryStream
                imgsignature.Image.Save(signa, imgsignature.Image.RawFormat)
                cmd.Parameters.AddWithValue("@Signature", signa.ToArray)




                con.Open()
                cmd.ExecuteNonQuery()
                con.Close()
                MessageBox.Show("Succesfully Added")
            End Using
        End Using
    End Sub

    Private Sub createqr()

        Dim text As String = txtIdno.Text
        Dim enco As QRCodeEncoder = New QRCodeEncoder()
        Dim qrImage As Bitmap = enco.Encode(text)

        imgqr.Image = qrImage

    End Sub

    Private Sub saveQr()

        Dim sfd As New SaveFileDialog
        sfd.FileName = "QRCodeImage"
        sfd.Filter = "PNG Image Only(*.png)|*.png"
        sfd.AddExtension = True
        If sfd.ShowDialog = Windows.Forms.DialogResult.OK Then
            Try
                imgqr.Image.Save(sfd.FileName, System.Drawing.Imaging.ImageFormat.Png)
                MsgBox("Save Successfully", MsgBoxStyle.Information)
            Catch ex As Exception

            End Try
        End If

    End Sub



    Private Sub btnscan_Click(sender As System.Object, e As System.EventArgs) Handles btnscan.Click

        Dim ofd As New OpenFileDialog
        ofd.Filter = "images Files|*.png;*.jpeg;*.jpg"
        If ofd.ShowDialog = Windows.Forms.DialogResult.OK Then

            qrlocation = ofd.FileName
            imgqr.Image = Image.FromFile(qrlocation)
            Call Decode()
            Call getdata()
            txtIdno.Enabled = False
            btnAdd.Enabled = False

            btnupdate.Enabled = True
            btnDelete.Enabled = True


        End If

    End Sub

    Private Sub Decode()

        Dim deco As QRCodeDecoder = New QRCodeDecoder()
        txtIdno.Text = deco.decode(New QRCodeBitmapImage(imgqr.Image))

        Call updateqr()


    End Sub

    Private Sub updateqr()

        Dim query As String = "Update studentid set qr = @qr where idno = @idno"
        Using con As SqlConnection = New SqlConnection(connection)
            Using cmd As SqlCommand = New SqlCommand(query, con)

                cmd.Parameters.AddWithValue("@idno", txtIdno.Text)

                Dim qrcode As New MemoryStream
                imgqr.Image.Save(qrcode, imgqr.Image.RawFormat)

                cmd.Parameters.AddWithValue("@qr", qrcode.ToArray)

                con.Open()
                cmd.ExecuteNonQuery()
                con.Close()

                Call binddata()

            End Using
        End Using
    End Sub

    Private Sub getdata()

        Dim query As String = "SELECT * FROM studentid WHERE idno = @idno"
        Using con As SqlConnection = New SqlConnection(connection)
            Using cmd As SqlCommand = New SqlCommand(query, con)
                cmd.Parameters.AddWithValue("@idno", txtIdno.Text)
                Using da As New SqlDataAdapter()
                    da.SelectCommand = cmd

                    Using dt As New DataTable()
                        da.Fill(dt)

                        If dt.Rows.Count > 0 Then

                            ComboCourse.Text = dt.Rows(0)(2).ToString
                            txtFullname.Text = dt.Rows(0)(3).ToString
                            txtGuardName.Text = dt.Rows(0)(4).ToString
                            txtAddress.Text = dt.Rows(0)(5).ToString
                            txtcpno.Text = dt.Rows(0)(6).ToString

                            Dim profile As Byte()
                            profile = dt.Rows(0)(7)
                            Dim memstr As New MemoryStream(profile)
                            Imgprofile.Image = Image.FromStream(memstr)

                            Dim signature As Byte()
                            signature = dt.Rows(0)(8)
                            Dim memstr2 As New MemoryStream(signature)
                            imgsignature.Image = Image.FromStream(memstr2)



         

                        Else
                            MsgBox("No Data Found")

                        End If
                    End Using
                End Using
            End Using
        End Using

    End Sub


    Private Sub btnupdate_Click(sender As System.Object, e As System.EventArgs) Handles btnupdate.Click

        Call updatedata()
        Call binddata()
        Call autoclear()
        btnupdate.Enabled = False
        btnDelete.Enabled = False
        btnAdd.Enabled = True

    End Sub

    Private Sub updatedata()
        Dim IDno As String = txtIdno.Text
        Dim Course As String = ComboCourse.Text
        Dim Fullname As String = txtFullname.Text
        Dim GName As String = txtGuardName.Text
        Dim Add As String = txtAddress.Text
        Dim Cpno As String = txtcpno.Text


        Dim query As String = "Update Studentid Set Course = @Course, Fname = @Fullname, Gname = @Gname, Address = @Address, Cpno = @CPNo, Profilepic = @Profilepic, Signature = @Signature Where IDNo = @IDno"
        Using con As SqlConnection = New SqlConnection(connection)
            Using cmd As SqlCommand = New SqlCommand(query, con)


                cmd.Parameters.AddWithValue("@IDno", IDno)
                cmd.Parameters.AddWithValue("@Course", Course)
                cmd.Parameters.AddWithValue("@Fullname", Fullname)
                cmd.Parameters.AddWithValue("@Gname", GName)
                cmd.Parameters.AddWithValue("@Address", Add)
                cmd.Parameters.AddWithValue("@CPNo", Cpno)


                Dim profile As New MemoryStream
                Imgprofile.Image.Save(profile, Imgprofile.Image.RawFormat)
                cmd.Parameters.AddWithValue("@Profilepic", profile.ToArray)

                Dim signa As New MemoryStream
                imgsignature.Image.Save(signa, imgsignature.Image.RawFormat)
                cmd.Parameters.AddWithValue("@Signature", signa.ToArray)

                con.Open()
                cmd.ExecuteNonQuery()
                con.Close()
                MessageBox.Show("Succesfully Updated")
            End Using
        End Using
    End Sub

    Private Sub btnDelete_Click(sender As System.Object, e As System.EventArgs) Handles btnDelete.Click

        Delete = MsgBox("Are you sure to delete this?", vbYesNo)

        If Delete = vbYes Then
            Call deletedata()
            btnDelete.Enabled = False
            btnupdate.Enabled = False
            btnAdd.Enabled = True
            Call binddata()
            Call autoclear()
        Else
            MsgBox("Kyut ko")
        End If


    End Sub

    Private Sub deletedata()

        Dim IDNo As String = txtIdno.Text

        Dim query As String = "delete studentid where IDNo = @IDNo"
        Using con As SqlConnection = New SqlConnection(connection)
            Using cmd As SqlCommand = New SqlCommand(query, con)

                cmd.Parameters.AddWithValue("@IDNo", IDNo)
                con.Open()
                cmd.ExecuteNonQuery()
                con.Close()
                MessageBox.Show("Succesfully Deleted")
            End Using
        End Using
    End Sub


    Private Sub Button7_Click(sender As System.Object, e As System.EventArgs) Handles Button7.Click
        Dim ofd As New OpenFileDialog
        ofd.Filter = "images Files|*.png;*.jpeg;*.jpg"
        If ofd.ShowDialog = Windows.Forms.DialogResult.OK Then
            qrid = ofd.FileName
            picqr.Image = Image.FromFile(qrid)

            Call decodeid()
            Call getiddata()

        End If

      
    End Sub

    Private Sub decodeid()

        Dim deco As QRCodeDecoder = New QRCodeDecoder()
        lblidno.Text = deco.decode(New QRCodeBitmapImage(picqr.Image))

    End Sub

    Private Sub getiddata()


        Dim query As String = "SELECT * FROM studentid WHERE idno = @idno"
        Using con As SqlConnection = New SqlConnection(connection)
            Using cmd As SqlCommand = New SqlCommand(query, con)
                cmd.Parameters.AddWithValue("@idno", lblidno.Text)
                Using da As New SqlDataAdapter()
                    da.SelectCommand = cmd

                    Using dt As New DataTable()
                        da.Fill(dt)

                        If dt.Rows.Count > 0 Then

                            lblcourse.Text = dt.Rows(0)(2).ToString
                            lblfname.Text = dt.Rows(0)(3).ToString
                            lblGname.Text = dt.Rows(0)(4).ToString
                            lbladdress.Text = dt.Rows(0)(5).ToString
                            lblidno.Text = dt.Rows(0)(6).ToString

                            Dim profile As Byte()
                            profile = dt.Rows(0)(7)
                            Dim memstr As New MemoryStream(profile)
                            Picprofile.Image = Image.FromStream(memstr)

                            Dim signature As Byte()
                            signature = dt.Rows(0)(8)
                            Dim memstr2 As New MemoryStream(signature)
                            picqr.Image = Image.FromStream(memstr2)





                        Else
                            MsgBox("No Data Found")

                        End If
                    End Using
                End Using
            End Using
        End Using
    End Sub



   
End Class
