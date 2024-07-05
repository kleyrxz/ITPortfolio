Public Class Formcar
    Dim speed As Integer
    Dim road(7) As PictureBox
    Dim score As Integer = 0

    Private Sub Formcar_Load(sender As System.Object, e As System.EventArgs) Handles MyBase.Load
        speed = 3
        road(0) = PictureBox1
        road(1) = PictureBox2
        road(2) = PictureBox3
        road(3) = PictureBox4
        road(4) = PictureBox5
        road(5) = PictureBox6
        road(6) = PictureBox7
        road(7) = PictureBox8
    End Sub
    Private Sub Road_Mover_Tick(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Road_Mover.Tick
        For x As Integer = 0 To 7
            road(x).Top += speed
            If road(x).Top >= Me.Height Then
                road(x).Top = -road(x).Height
            End If
        Next
        If score > 10 And score < 20 Then
            speed = 5
        End If
        If score > 20 And score < 30 Then
            speed = 6
        End If
        If score > 30 Then
            speed = 7
        End If
        speedtxt.Text = "Speed " & speed
        If (car.Bounds.IntersectsWith(enemy1.Bounds)) Then
            GameOver()
        End If
        If (car.Bounds.IntersectsWith(enemy2.Bounds)) Then
            GameOver()
        End If
        If (car.Bounds.IntersectsWith(enemy3.Bounds)) Then
            GameOver()
        End If
    End Sub

    Private Sub GameOver()
        Replaybtn.Visible = True
        Endgame.Visible = True
        Road_Mover.Stop()
        Enemy1_Mover.Stop()
        Enemy2_Mover.Stop()
        Enemy3_Mover.Stop()
    End Sub

    Private Sub Form1_KeyDown(ByVal sender As System.Object, ByVal e As System.Windows.Forms.KeyEventArgs) Handles MyBase.KeyDown
        If e.KeyCode = Keys.Right Then
            Right_Mover.Start()
        End If
        If e.KeyCode = Keys.Left Then
            Left_Mover.Start()
        End If
    End Sub

    Private Sub Right_Mover_Tick(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Right_Mover.Tick
        If (car.Location.X < 240) Then
            car.Left += 5
        End If
    End Sub

    Private Sub Left_Mover_Tick(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Left_Mover.Tick
        If (car.Location.X > 0) Then
            car.Left -= 5
        End If
    End Sub

    Private Sub Form1_KeyUp(ByVal sender As System.Object, ByVal e As System.Windows.Forms.KeyEventArgs) Handles MyBase.KeyUp
        Right_Mover.Stop()
        Left_Mover.Stop()
    End Sub

    Private Sub Enemy1_Mover_Tick(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Enemy1_Mover.Tick
        enemy1.Top += speed / 2
        If enemy1.Top >= Me.Height Then
            score += 1
            scoretxt.Text = "Score " & score
            enemy1.Top = -CInt(Math.Ceiling(Rnd() * 200)) + enemy1.Height
            enemy1.Left = CInt(Math.Ceiling(Rnd() * 50)) + 0
        End If
    End Sub

    Private Sub Enemy2_Mover_Tick(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Enemy2_Mover.Tick
        enemy2.Top += speed
        If enemy2.Top >= Me.Height Then
            score += 1
            scoretxt.Text = "Score " & score
            enemy2.Top = -CInt(Math.Ceiling(Rnd() * 200)) + enemy2.Height
            enemy2.Left = CInt(Math.Ceiling(Rnd() * 50)) + 100
        End If
    End Sub

    Private Sub Enemy3_Mover_Tick(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Enemy3_Mover.Tick
        enemy3.Top += speed * 3 / 2
        If enemy3.Top >= Me.Height Then
            score += 1
            scoretxt.Text = "Score " & score
            enemy3.Top = -CInt(Math.Ceiling(Rnd() * 200)) + enemy3.Height
            enemy3.Left = CInt(Math.Ceiling(Rnd() * 40)) + 150
        End If
    End Sub

    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Replaybtn.Click
        score = 0
        Me.Controls.Clear()
        InitializeComponent()
        Formcar_Load(e, e)
    End Sub
End Class