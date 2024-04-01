' NOTE: You can use the "Rename" command on the context menu to change the class name "Service1" in code, svc and config file together.
' NOTE: In order to launch WCF Test Client for testing this service, please select Service1.svc or Service1.svc.vb at the Solution Explorer and start debugging.

Imports System.IO
Imports System.Data.DataTable
Imports Microsoft.Reporting.WebForms
Imports iTextSharp.text.pdf
Imports System.IO.Compression

Public Class Service1
    Implements IService1

    Public Sub New()
    End Sub

    Public Function GetData(ByVal value As Integer) As String Implements IService1.GetData
        Return String.Format("You entered: {0}", value)
    End Function

    Public Function GetDataUsingDataContract(ByVal composite As CompositeType) As CompositeType Implements IService1.GetDataUsingDataContract
        If composite Is Nothing Then
            Throw New ArgumentNullException("composite")
        End If
        If composite.BoolValue Then
            composite.StringValue &= "Suffix"
        End If
        Return composite
    End Function

    Private D_DAT As System.Data.DataSet

    ' 
    '*********************************************************************************************************
    '*
    '*  処理概要：OUTPUT PDF
    '*
    '*  更新日　：2023/06/13
    '*  更新者　：KyVD
    '*
    '*********************************************************************************************************
    Public Function FNC_WEB_PDF(
       ByVal P1 As String(),'Screen name
       ByVal P2 As String(),'Sql query string
       ByVal P3 As String(),'File name export
       ByVal P4 As String,'File name ouput
       Optional ByVal P5 As String = "False"'Zip file
   ) As String Implements IService1.FNC_WEB_PDF
        '
        Dim D_ERR As Boolean = False         'エラーフラグ
        Dim D_ERR_MSG As String = ""         'エラーメッセージ
        Dim I As Integer                     'ループカウンター
        Dim D_UTL_RDB As Utl_RDB = Nothing 'データベースクラス
        '
        Dim D_SQL As String = ""
        Dim A_SQL As Array = {}
        '
        Dim D_Folder_Path As String = System.AppDomain.CurrentDomain.BaseDirectory


        Dim D_File_Log As String = ""
        '
        '
        Dim D_CNT As Integer = 0
        Dim D_File_Name As String() = {}
        Dim D_Folder_Output = D_PTH() + P4 + "_" + Format(Now(), "yyyyMMddHHmmss")
        Dim D_File_Output = D_Folder_Output + ".pdf"
        '
        Dim D_status As String = "200"
        Dim D_Message As String = String.Empty
        Dim D_Delimete As String = "|#|@"
        Dim D_SourceName As String = String.Empty
        '
        Dim J As Integer = 0
        '
        Try
            '
            D_File_Log = ConfigurationManager.AppSettings("FIL_LOG")
            '
            D_UTL_RDB = New Utl_RDB()
            '
            For I = 0 To UBound(P1) Step 1
                '帳票選択
                D_ERR = False

                D_SQL = P2(I).ToString
                '
                A_SQL = P2(I).Split("&;")
                If A_SQL.Length = 1 Then
                    'Trace log                    
                    D_DAT = D_UTL_RDB.FNC_GET_DAT(D_SQL)
                    '
                    'If D_DAT.Tables(0).Rows.Count = 0 And P2.Length = 1 Then
                    '    'D_status = "203"
                    '    J = J + 1
                    '    GoTo EXIT_FOR
                    '    'GoTo EXIT_FUNCTION
                    'End If
                End If
                '
                D_SourceName = P1(I)
                '
                Select Case P1(I)
                    Case "Fab090280r"
                        Dim D_Title = P3(I)
                        Dim D_RPT = New ReportViewer
                        D_RPT.ProcessingMode = ProcessingMode.Local
                        D_RPT.LocalReport.DataSources.Add(New ReportDataSource("Fab090280r", D_DAT.Tables(0)))
                        Dim D_RPT_RES = SUB_ADD_RPT(D_RPT, D_Title, D_Folder_Path + "Reports\Fab090630i\Fab090280r.rdlc")
                        Dim D_Name = D_RPT_RES(0)
                        '
                        ReDim Preserve D_File_Name(I)
                        D_File_Name(I) = D_Name
                    Case Else
                        D_ERR = True
                        D_ERR_MSG = "帳票が選択できませんでした。"
                        D_Message = D_ERR_MSG
                        Exit For
                End Select
                '
EXIT_FOR:
            Next I
            '
            If D_File_Name.Length = 1 And P5 = "False" Then
                D_File_Output = D_File_Name(0)
            Else
                If P5 = "True" Then
                    ZipFiles(D_File_Name, D_Folder_Output)
                    D_File_Output = D_Folder_Output + ".zip"
                Else
                    MergePdfFiles(D_File_Name, D_File_Output)
                End If
            End If
            D_status = "200"
        Catch ex As Exception
            Utl_ERR.FNC_ERR_RTN(ex, D_SQL)
            D_status = "201"
            D_Message = ex.Message
        End Try
        '

EXIT_FUNCTION:
        'Trace Log SQL                 
        Utl_ERR.WriteLogFile(D_SQL, D_SourceName, False)
        ' End Trace

        FNC_WEB_PDF = "{" + """" + "status" + """" + ":" + D_status + "," + """" + "filename" + """" + ":""" + Path.GetFileName(D_File_Output) + """," + """" + "message" + """" + ":" + """" + D_Message + """ }"
EXIT_SUB:
    End Function

    Public Shared Function D_PTH()
        Return ConfigurationManager.AppSettings("FIL_SAV_PTH")
    End Function
    '*********************************************************************************************************
    '*
    '*  処理概要：　　　　Create file pdf
    '*  
    '*  更新日　：　　　　2015/26/03
    '*  更新者　：　　　　KyVD
    '*
    '*********************************************************************************************************
    Public Shared Function SUB_ADD_RPT(ByVal P1 As ReportViewer, ByVal P2 As String, ByVal P3 As String) As String()
        Dim D_RTN As String = ""
        Dim filePath As String = ""
        Try
            If Not Directory.Exists(D_PTH) Then
                'ファイルを格納するディレクトリ非存在 -> 作成
                Directory.CreateDirectory(D_PTH)
            End If
            filePath = D_PTH() + P2 + Format(Now(), "yyyyMMddHHmmssfff") + ".pdf"
            '
            Using fs As New System.IO.FileStream(filePath, FileMode.Create)
                P1.LocalReport.ReportPath = P3
                Dim bytes As Byte() = P1.LocalReport.Render("PDF")
                fs.Write(bytes, 0, bytes.Length)
                fs.Close()
            End Using
            '
            D_RTN = "TRUE"
        Catch ex As Exception
            Utl_ERR.FNC_ERR_RTN(ex)
            filePath = ""
            D_RTN = "FALSE"
        End Try
SUB_EXIT:
        SUB_ADD_RPT = {filePath, D_RTN}
        Exit Function
    End Function

    Public Shared Function MergePdfFiles(ByVal pdfFiles() As String, ByVal outputPath As String) As Boolean
        Dim D_RTN As Boolean = False
        Try
            ' Create document object
            Dim PDFdoc As New iTextSharp.text.Document()
            ' Create a object of FileStream which will be disposed at the end
            Using MyFileStream As New System.IO.FileStream(outputPath, System.IO.FileMode.Create)
                ' Create a PDFwriter
                Dim PDFwriter As New PdfCopy(PDFdoc, MyFileStream)
                If PDFwriter Is Nothing Then
                    Return D_RTN
                End If
                ' Open the PDFdocument
                PDFdoc.Open()
                For Each fileName As String In pdfFiles
                    ' Create a PDFreader for a certain PDFdocument
                    Dim PDFreader As New PdfReader(fileName)
                    PDFreader.ConsolidateNamedDestinations()
                    ' Add content
                    For i As Integer = 1 To PDFreader.NumberOfPages
                        Dim page As PdfImportedPage = PDFwriter.GetImportedPage(PDFreader, i)
                        PDFwriter.AddPage(page)
                    Next i
                    Dim form As PRAcroForm = PDFreader.AcroForm
                    If form IsNot Nothing Then
                        'PdfCopy(PDFreader)
                    End If
                    ' Close PDFreader
                    PDFreader.Close()

                Next fileName

                ' Close the PDFdocument and PDFwriter
                PDFwriter.Close()
                PDFdoc.Close()
                'delete the PdfFiles you processed
                For Each fileName As String In pdfFiles
                    File.Delete(fileName)
                Next
            End Using ' Disposes the Object of FileStream
            D_RTN = True
        Catch ex As Exception
            Utl_ERR.FNC_ERR_RTN(ex)
            D_RTN = False
        End Try
SUB_EXIT:
        Return D_RTN
        Exit Function
    End Function

    Public Shared Function ZipFiles(ByVal pdfFiles() As String, ByVal outputPath As String) As Boolean
        Dim D_RTN As Boolean = False
        Try
            Directory.CreateDirectory(outputPath)
            For Each fileName As String In pdfFiles
                File.Move(fileName, outputPath + "/" + Path.GetFileName(fileName))
            Next
            ZipFile.CreateFromDirectory(outputPath, outputPath + ".zip")
            Directory.Delete(outputPath, True)
            Return True
        Catch ex As Exception
            Utl_ERR.FNC_ERR_RTN(ex)
            D_RTN = False
        End Try
SUB_EXIT:
        Return D_RTN
    End Function

End Class