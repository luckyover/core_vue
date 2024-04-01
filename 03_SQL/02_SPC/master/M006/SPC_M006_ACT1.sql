IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M006_ACT1]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M006_ACT1
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- EXEC SPC_M006_ACT1 49, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, '809','M001','172.19.0.1';
--****************************************************************************************
--*  
--*  処理概要/process overview	:	Insert or update data for M006
--*  
--*  作成日/create date			:	2024/02/19
--*　作成者/creater				:	ThuanNV - ANS909
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE SPC_M006_ACT1
	@P_supplier_cd					INT 			= 0
,   @P_supplier_div					SMALLINT 		= 0
,   @P_supplier_nm					NVARCHAR(50) 	= N''
,   @P_supplier_kn_nm				NVARCHAR(50) 	= N''
,   @P_supplier_ab_nm				NVARCHAR(30) 	= N''
,   @P_supplier_zip					NVARCHAR(8) 	= N''
,   @P_supplier_address1			NVARCHAR(50) 	= N''
,   @P_supplier_address2			NVARCHAR(50) 	= N''
,   @P_supplier_address3			NVARCHAR(100) 	= N''
,   @P_supplier_tel					NVARCHAR(20) 	= N''
,   @P_supplier_fax					NVARCHAR(20) 	= N''
,   @P_supplier_department_nm		NVARCHAR(30) 	= N''
,   @P_supplier_manager_nm			NVARCHAR(30) 	= N''
,   @P_supplier_mail_address		NVARCHAR(255) 	= N''
,   @P_supplier_class_div1			SMALLINT 		= 0
,   @P_supplier_class_div2			SMALLINT 		= 0
,   @P_supplier_class_div3			SMALLINT 		= 0
,   @P_supplier_closing_div			SMALLINT 		= 0
,   @P_transfer_date1				SMALLINT 		= 0
,   @P_transfer_date2				SMALLINT 		= 0
,   @P_remarks						NVARCHAR(100) 	= N''
,	@P_act_user_cd					NVARCHAR(10)	= N''
,	@P_prg							NVARCHAR(30)	= N''
,	@P_ip							NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	DECLARE 
	-- variable general
		@w_time						DATETIME2		=	SYSDATETIME()
	,	@ERR_TBL					ERRTABLE
	-- variable log
    ,   @w_prs_mode					NVARCHAR(200)   =   N'Insert'
    ,   @w_prs_result				NVARCHAR(200)   =   N'OK'
	,	@w_remarks					NVARCHAR(200)	=	N''
	,	@w_table_key				NVARCHAR(200)	=	N'supplier_cd=' + CONVERT(NVARCHAR, @P_supplier_cd)	

	-- START TRANSACTION 
	BEGIN TRANSACTION
	-- TRY CATCH EXCEPTION
	BEGIN TRY
		IF EXISTS(SELECT 1 FROM M006 WITH(NOLOCK) WHERE supplier_cd = @P_supplier_cd AND del_flg <> 1)
		BEGIN
			SET @w_prs_mode = 'Update'
			UPDATE M006 SET
				supplier_div			= @P_supplier_div
			,	supplier_nm             = @P_supplier_nm
			,	supplier_kn_nm          = @P_supplier_kn_nm
			,	supplier_ab_nm          = @P_supplier_ab_nm
			,	supplier_zip            = @P_supplier_zip
			,	supplier_address1       = @P_supplier_address1
			,	supplier_address2       = @P_supplier_address2
			,	supplier_address3       = @P_supplier_address3
			,	supplier_tel            = @P_supplier_tel
			,	supplier_fax            = @P_supplier_fax
			,	supplier_department_nm  = @P_supplier_department_nm
			,	supplier_manager_nm     = @P_supplier_manager_nm
			,	supplier_mail_address   = @P_supplier_mail_address
			,	supplier_class_div1     = @P_supplier_class_div1
			,	supplier_class_div2     = @P_supplier_class_div2
			,	supplier_class_div3     = @P_supplier_class_div3
			,	supplier_closing_div     = @P_supplier_closing_div
			,	transfer_date1          = @P_transfer_date1
			,	transfer_date2          = @P_transfer_date2
			,	remarks                 = @P_remarks
			,	upd_user_cd				= @P_act_user_cd
			,	upd_prg					= @P_prg
			,	upd_ip					= @P_ip
			,	upd_tm					= @w_time
			,	del_user_cd				= NULL
			,	del_prg					= NULL
			,	del_ip					= NULL
			,	del_tm					= NULL
			,	del_flg					= 0
			WHERE
				supplier_cd					= @P_supplier_cd
		END
		ELSE
		BEGIN
			EXEC SPC_S001_INQ1 'M006', @P_supplier_cd OUT, @P_act_user_cd, @P_prg, @P_ip
			SET @w_table_key = 'supplier_cd=' + CONVERT(NVARCHAR, CONVERT(INT, @P_supplier_cd))
			INSERT INTO M006
			SELECT
				@P_supplier_cd
			,	@P_supplier_div
			,	@P_supplier_nm
			,	@P_supplier_kn_nm
			,	@P_supplier_ab_nm
			,	@P_supplier_zip
			,	@P_supplier_address1
			,	@P_supplier_address2
			,	@P_supplier_address3
			,	@P_supplier_tel
			,	@P_supplier_fax
			,	@P_supplier_department_nm
			,	@P_supplier_manager_nm
			,	@P_supplier_mail_address
			,	@P_supplier_class_div1
			,	@P_supplier_class_div2
			,	@P_supplier_class_div3
			,	@P_supplier_closing_div
			,	@P_transfer_date1
			,	@P_transfer_date2
			,	@P_remarks
			,	@P_act_user_cd
			,	@P_prg
			,	@P_ip
			,	@w_time
			,	NULL
			,	NULL
			,	NULL
			,	NULL
			,	NULL
			,	NULL
			,	NULL
			,	NULL
			,	0
		END
	END TRY
	BEGIN CATCH
		SET @w_prs_result	=	'NG'
		SET @w_remarks		=	N'Error'                                                           + CHAR(13) + CHAR(10) +
								N'Procedure : ' + ISNULL(ERROR_PROCEDURE(), N'???')                + CHAR(13) + CHAR(10) +
								N'Line : '      + ISNULL(CAST(ERROR_LINE() AS NVARCHAR(10)), N'0') + CHAR(13) + CHAR(10) +
								N'Message : '   + ISNULL(ERROR_MESSAGE(), N'An unexpected error occurred.')
        DELETE FROM @ERR_TBL
        INSERT INTO @ERR_TBL
        SELECT  
            N'E009'
        ,   N''
        ,   0
        ,   999
        ,   0
		,	N''
        ,   @w_remarks
	END CATCH
    IF EXISTS (SELECT 1 FROM @ERR_TBL)
	BEGIN
		IF(@@TRANCOUNT > 0)
        BEGIN
            ROLLBACK TRANSACTION
        END
	END
	ELSE
	BEGIN
		DELETE FROM @ERR_TBL
		IF(@@TRANCOUNT > 0)
        BEGIN
            COMMIT TRANSACTION
        END
	END
    -- Insert statements for procedure here
	COMPLETE_QUERY:

	EXEC SPC_S999_ACT1
		@P_act_user_cd
	,	@P_prg
	,	@w_prs_mode
	,	@w_table_key
	,	@w_prs_result
	,	@w_remarks

	SELECT * FROM @ERR_TBL

	SELECT @P_supplier_cd AS supplier_cd

END
GO
