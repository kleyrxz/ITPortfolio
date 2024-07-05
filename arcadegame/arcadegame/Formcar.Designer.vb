<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class Formcar
    Inherits System.Windows.Forms.Form

    'Form overrides dispose to clean up the component list.
    <System.Diagnostics.DebuggerNonUserCode()> _
    Protected Overrides Sub Dispose(ByVal disposing As Boolean)
        Try
            If disposing AndAlso components IsNot Nothing Then
                components.Dispose()
            End If
        Finally
            MyBase.Dispose(disposing)
        End Try
    End Sub

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.IContainer

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> _
    Private Sub InitializeComponent()
        Me.components = New System.ComponentModel.Container()
        Dim resources As System.ComponentModel.ComponentResourceManager = New System.ComponentModel.ComponentResourceManager(GetType(Formcar))
        Me.enemy1 = New System.Windows.Forms.PictureBox()
        Me.enemy2 = New System.Windows.Forms.PictureBox()
        Me.enemy3 = New System.Windows.Forms.PictureBox()
        Me.Enemy1_Mover = New System.Windows.Forms.Timer(Me.components)
        Me.PictureBox1 = New System.Windows.Forms.PictureBox()
        Me.Enemy2_Mover = New System.Windows.Forms.Timer(Me.components)
        Me.Replaybtn = New System.Windows.Forms.Button()
        Me.Enemy3_Mover = New System.Windows.Forms.Timer(Me.components)
        Me.scoretxt = New System.Windows.Forms.Label()
        Me.Right_Mover = New System.Windows.Forms.Timer(Me.components)
        Me.Endgame = New System.Windows.Forms.Label()
        Me.speedtxt = New System.Windows.Forms.Label()
        Me.car = New System.Windows.Forms.PictureBox()
        Me.Left_Mover = New System.Windows.Forms.Timer(Me.components)
        Me.PictureBox7 = New System.Windows.Forms.PictureBox()
        Me.PictureBox8 = New System.Windows.Forms.PictureBox()
        Me.PictureBox5 = New System.Windows.Forms.PictureBox()
        Me.PictureBox6 = New System.Windows.Forms.PictureBox()
        Me.PictureBox4 = New System.Windows.Forms.PictureBox()
        Me.PictureBox2 = New System.Windows.Forms.PictureBox()
        Me.PictureBox3 = New System.Windows.Forms.PictureBox()
        Me.Road_Mover = New System.Windows.Forms.Timer(Me.components)
        CType(Me.enemy1, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.enemy2, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.enemy3, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.PictureBox1, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.car, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.PictureBox7, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.PictureBox8, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.PictureBox5, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.PictureBox6, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.PictureBox4, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.PictureBox2, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.PictureBox3, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.SuspendLayout()
        '
        'enemy1
        '
        Me.enemy1.BackColor = System.Drawing.Color.Transparent
        Me.enemy1.Image = CType(resources.GetObject("enemy1.Image"), System.Drawing.Image)
        Me.enemy1.Location = New System.Drawing.Point(12, 98)
        Me.enemy1.Name = "enemy1"
        Me.enemy1.Size = New System.Drawing.Size(57, 76)
        Me.enemy1.SizeMode = System.Windows.Forms.PictureBoxSizeMode.StretchImage
        Me.enemy1.TabIndex = 27
        Me.enemy1.TabStop = False
        '
        'enemy2
        '
        Me.enemy2.BackColor = System.Drawing.Color.Transparent
        Me.enemy2.Image = CType(resources.GetObject("enemy2.Image"), System.Drawing.Image)
        Me.enemy2.Location = New System.Drawing.Point(114, -6)
        Me.enemy2.Name = "enemy2"
        Me.enemy2.Size = New System.Drawing.Size(57, 76)
        Me.enemy2.SizeMode = System.Windows.Forms.PictureBoxSizeMode.StretchImage
        Me.enemy2.TabIndex = 26
        Me.enemy2.TabStop = False
        '
        'enemy3
        '
        Me.enemy3.BackColor = System.Drawing.Color.Transparent
        Me.enemy3.Image = CType(resources.GetObject("enemy3.Image"), System.Drawing.Image)
        Me.enemy3.Location = New System.Drawing.Point(218, 78)
        Me.enemy3.Name = "enemy3"
        Me.enemy3.Size = New System.Drawing.Size(54, 71)
        Me.enemy3.SizeMode = System.Windows.Forms.PictureBoxSizeMode.StretchImage
        Me.enemy3.TabIndex = 25
        Me.enemy3.TabStop = False
        '
        'Enemy1_Mover
        '
        Me.Enemy1_Mover.Enabled = True
        Me.Enemy1_Mover.Interval = 10
        '
        'PictureBox1
        '
        Me.PictureBox1.BackColor = System.Drawing.Color.White
        Me.PictureBox1.Location = New System.Drawing.Point(75, 73)
        Me.PictureBox1.Name = "PictureBox1"
        Me.PictureBox1.Size = New System.Drawing.Size(13, 101)
        Me.PictureBox1.TabIndex = 16
        Me.PictureBox1.TabStop = False
        '
        'Enemy2_Mover
        '
        Me.Enemy2_Mover.Enabled = True
        Me.Enemy2_Mover.Interval = 10
        '
        'Replaybtn
        '
        Me.Replaybtn.BackColor = System.Drawing.Color.SeaShell
        Me.Replaybtn.Font = New System.Drawing.Font("Wide Latin", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Replaybtn.ForeColor = System.Drawing.Color.Firebrick
        Me.Replaybtn.Location = New System.Drawing.Point(94, 193)
        Me.Replaybtn.Name = "Replaybtn"
        Me.Replaybtn.Size = New System.Drawing.Size(103, 40)
        Me.Replaybtn.TabIndex = 30
        Me.Replaybtn.Text = "Replay"
        Me.Replaybtn.UseVisualStyleBackColor = False
        Me.Replaybtn.Visible = False
        '
        'Enemy3_Mover
        '
        Me.Enemy3_Mover.Enabled = True
        Me.Enemy3_Mover.Interval = 10
        '
        'scoretxt
        '
        Me.scoretxt.AutoSize = True
        Me.scoretxt.Font = New System.Drawing.Font("Kristen ITC", 9.75!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.scoretxt.ForeColor = System.Drawing.Color.PeachPuff
        Me.scoretxt.Location = New System.Drawing.Point(5, 7)
        Me.scoretxt.Name = "scoretxt"
        Me.scoretxt.Size = New System.Drawing.Size(64, 18)
        Me.scoretxt.TabIndex = 29
        Me.scoretxt.Text = "Score 0"
        '
        'Right_Mover
        '
        Me.Right_Mover.Interval = 10
        '
        'Endgame
        '
        Me.Endgame.AutoSize = True
        Me.Endgame.BackColor = System.Drawing.Color.White
        Me.Endgame.Font = New System.Drawing.Font("Ravie", 15.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Endgame.ForeColor = System.Drawing.Color.Tomato
        Me.Endgame.Location = New System.Drawing.Point(70, 144)
        Me.Endgame.Name = "Endgame"
        Me.Endgame.Size = New System.Drawing.Size(160, 30)
        Me.Endgame.TabIndex = 28
        Me.Endgame.Text = "Game Over"
        Me.Endgame.Visible = False
        '
        'speedtxt
        '
        Me.speedtxt.AutoSize = True
        Me.speedtxt.Font = New System.Drawing.Font("Kristen ITC", 9.75!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.speedtxt.ForeColor = System.Drawing.Color.PeachPuff
        Me.speedtxt.Location = New System.Drawing.Point(215, 7)
        Me.speedtxt.Name = "speedtxt"
        Me.speedtxt.Size = New System.Drawing.Size(65, 18)
        Me.speedtxt.TabIndex = 31
        Me.speedtxt.Text = "Speed 0"
        '
        'car
        '
        Me.car.BackColor = System.Drawing.Color.Transparent
        Me.car.Image = CType(resources.GetObject("car.Image"), System.Drawing.Image)
        Me.car.Location = New System.Drawing.Point(125, 298)
        Me.car.Name = "car"
        Me.car.Size = New System.Drawing.Size(33, 49)
        Me.car.SizeMode = System.Windows.Forms.PictureBoxSizeMode.StretchImage
        Me.car.TabIndex = 24
        Me.car.TabStop = False
        '
        'Left_Mover
        '
        Me.Left_Mover.Interval = 10
        '
        'PictureBox7
        '
        Me.PictureBox7.BackColor = System.Drawing.Color.White
        Me.PictureBox7.Location = New System.Drawing.Point(184, 310)
        Me.PictureBox7.Name = "PictureBox7"
        Me.PictureBox7.Size = New System.Drawing.Size(13, 99)
        Me.PictureBox7.TabIndex = 23
        Me.PictureBox7.TabStop = False
        '
        'PictureBox8
        '
        Me.PictureBox8.BackColor = System.Drawing.Color.White
        Me.PictureBox8.Location = New System.Drawing.Point(75, 310)
        Me.PictureBox8.Name = "PictureBox8"
        Me.PictureBox8.Size = New System.Drawing.Size(13, 99)
        Me.PictureBox8.TabIndex = 22
        Me.PictureBox8.TabStop = False
        '
        'PictureBox5
        '
        Me.PictureBox5.BackColor = System.Drawing.Color.White
        Me.PictureBox5.Location = New System.Drawing.Point(184, 193)
        Me.PictureBox5.Name = "PictureBox5"
        Me.PictureBox5.Size = New System.Drawing.Size(13, 99)
        Me.PictureBox5.TabIndex = 21
        Me.PictureBox5.TabStop = False
        '
        'PictureBox6
        '
        Me.PictureBox6.BackColor = System.Drawing.Color.White
        Me.PictureBox6.Location = New System.Drawing.Point(75, 193)
        Me.PictureBox6.Name = "PictureBox6"
        Me.PictureBox6.Size = New System.Drawing.Size(13, 99)
        Me.PictureBox6.TabIndex = 20
        Me.PictureBox6.TabStop = False
        '
        'PictureBox4
        '
        Me.PictureBox4.BackColor = System.Drawing.Color.White
        Me.PictureBox4.Location = New System.Drawing.Point(75, -48)
        Me.PictureBox4.Name = "PictureBox4"
        Me.PictureBox4.Size = New System.Drawing.Size(13, 101)
        Me.PictureBox4.TabIndex = 18
        Me.PictureBox4.TabStop = False
        '
        'PictureBox2
        '
        Me.PictureBox2.BackColor = System.Drawing.Color.White
        Me.PictureBox2.Location = New System.Drawing.Point(184, -48)
        Me.PictureBox2.Name = "PictureBox2"
        Me.PictureBox2.Size = New System.Drawing.Size(13, 101)
        Me.PictureBox2.TabIndex = 17
        Me.PictureBox2.TabStop = False
        '
        'PictureBox3
        '
        Me.PictureBox3.BackColor = System.Drawing.Color.White
        Me.PictureBox3.Location = New System.Drawing.Point(184, 73)
        Me.PictureBox3.Name = "PictureBox3"
        Me.PictureBox3.Size = New System.Drawing.Size(13, 101)
        Me.PictureBox3.TabIndex = 19
        Me.PictureBox3.TabStop = False
        '
        'Road_Mover
        '
        Me.Road_Mover.Enabled = True
        Me.Road_Mover.Interval = 10
        '
        'Formcar
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.BackColor = System.Drawing.Color.DimGray
        Me.ClientSize = New System.Drawing.Size(284, 361)
        Me.Controls.Add(Me.car)
        Me.Controls.Add(Me.enemy1)
        Me.Controls.Add(Me.enemy2)
        Me.Controls.Add(Me.enemy3)
        Me.Controls.Add(Me.Replaybtn)
        Me.Controls.Add(Me.scoretxt)
        Me.Controls.Add(Me.Endgame)
        Me.Controls.Add(Me.speedtxt)
        Me.Controls.Add(Me.PictureBox7)
        Me.Controls.Add(Me.PictureBox8)
        Me.Controls.Add(Me.PictureBox5)
        Me.Controls.Add(Me.PictureBox6)
        Me.Controls.Add(Me.PictureBox4)
        Me.Controls.Add(Me.PictureBox2)
        Me.Controls.Add(Me.PictureBox3)
        Me.Controls.Add(Me.PictureBox1)
        Me.MaximumSize = New System.Drawing.Size(300, 400)
        Me.MinimumSize = New System.Drawing.Size(300, 400)
        Me.Name = "Formcar"
        Me.Text = "Formcar"
        CType(Me.enemy1, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.enemy2, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.enemy3, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.PictureBox1, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.car, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.PictureBox7, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.PictureBox8, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.PictureBox5, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.PictureBox6, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.PictureBox4, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.PictureBox2, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.PictureBox3, System.ComponentModel.ISupportInitialize).EndInit()
        Me.ResumeLayout(False)
        Me.PerformLayout()

    End Sub
    Friend WithEvents enemy1 As System.Windows.Forms.PictureBox
    Friend WithEvents enemy2 As System.Windows.Forms.PictureBox
    Friend WithEvents enemy3 As System.Windows.Forms.PictureBox
    Friend WithEvents Enemy1_Mover As System.Windows.Forms.Timer
    Friend WithEvents PictureBox1 As System.Windows.Forms.PictureBox
    Friend WithEvents Enemy2_Mover As System.Windows.Forms.Timer
    Friend WithEvents Replaybtn As System.Windows.Forms.Button
    Friend WithEvents Enemy3_Mover As System.Windows.Forms.Timer
    Friend WithEvents scoretxt As System.Windows.Forms.Label
    Friend WithEvents Right_Mover As System.Windows.Forms.Timer
    Friend WithEvents Endgame As System.Windows.Forms.Label
    Friend WithEvents speedtxt As System.Windows.Forms.Label
    Friend WithEvents car As System.Windows.Forms.PictureBox
    Friend WithEvents Left_Mover As System.Windows.Forms.Timer
    Friend WithEvents PictureBox7 As System.Windows.Forms.PictureBox
    Friend WithEvents PictureBox8 As System.Windows.Forms.PictureBox
    Friend WithEvents PictureBox5 As System.Windows.Forms.PictureBox
    Friend WithEvents PictureBox6 As System.Windows.Forms.PictureBox
    Friend WithEvents PictureBox4 As System.Windows.Forms.PictureBox
    Friend WithEvents PictureBox2 As System.Windows.Forms.PictureBox
    Friend WithEvents PictureBox3 As System.Windows.Forms.PictureBox
    Friend WithEvents Road_Mover As System.Windows.Forms.Timer
End Class
